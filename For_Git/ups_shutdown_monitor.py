#!/usr/bin/env python3
import RPi.GPIO as GPIO
import time
import subprocess
import logging

# ログ設定（必要に応じてパス変更）
logging.basicConfig(
    filename='/var/log/ups_shutdown_monitor.log',
    level=logging.INFO,
    format='%(asctime)s %(levelname)s %(message)s'
)

# UPS HAT の PF 信号を読む GPIO
PF_PIN = 17  # BCM番号

# いったんシャットダウン命令を出したら二重発行を避けるためのフラグ
shutdown_initiated = False

def pf_callback(channel):
    global shutdown_initiated
    # GPIO17 が LOW になった＝AC入力喪失（停電）を検知
    if GPIO.input(PF_PIN) == GPIO.LOW:
        if not shutdown_initiated:
            shutdown_initiated = True
            logging.info('Power Fail detected on GPIO%d. Initiating shutdown.' % PF_PIN)
            # すぐにシャットダウン
            subprocess.call(['sudo', 'shutdown', '-h', 'now', 'Power failure detected'])
    else:
        # PF が HIGH に戻る＝AC復帰した場合（サージなどもあり得る）
        logging.info('Power Fail signal returned to HIGH (AC may be restored).')

def main():
    global shutdown_initiated

    # GPIO 初期化
    GPIO.setmode(GPIO.BCM)
    GPIO.setup(PF_PIN, GPIO.IN, pull_up_down=GPIO.PUD_UP)
    # PF_PIN の立ち下がり（HIGH→LOW）を割り込み検知
    GPIO.add_event_detect(PF_PIN, GPIO.BOTH, callback=pf_callback, bouncetime=200)

    logging.info('UPS shutdown monitor started.')
    try:
        # 無限ループで待機。割り込みでシャットダウン処理が呼ばれる。
        while True:
            time.sleep(1)
    except KeyboardInterrupt:
        pass
    finally:
        GPIO.cleanup()
        logging.info('UPS shutdown monitor stopped.')

if __name__ == '__main__':
    main()
