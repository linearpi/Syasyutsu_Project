#!/bin/bash
exec > /tmp/sync-rtc.log 2>&1
set -eux

# RTCサーバ情報
RASPI_IP="192.168.50.154"
RASPI_USER="j2421312"
SSH_KEY="$HOME/.ssh/id_rsa"

# Pingチェック（1回だけ）
if ! ping -c1 -W1 "$RASPI_IP" &>/dev/null; then
  echo "RTCサーバ応答なし: $RASPI_IP"
  exit 1
fi

# SSHで日付取得
TIME=$(
  ssh -i "$SSH_KEY" \
      -o ConnectTimeout=5 \
      -o StrictHostKeyChecking=no \
      "${RASPI_USER}@${RASPI_IP}" \
      'date "+%Y-%m-%d %H:%M:%S"'
)

# 正常取得ならシステム時刻・RTCに反映
if [[ $TIME =~ ^[0-9]{4}-[0-9]{2}-[0-9]{2} ]]; then
  echo "取得成功: $TIME"
  sudo date -s "$TIME"
  sudo hwclock -w
  exit 0
else
  echo "時刻取得に失敗: '$TIME'"
  exit 1
fi
