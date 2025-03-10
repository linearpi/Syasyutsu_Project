import sys
import os
sys.path.append(os.path.dirname(os.path.abspath(__file__)))
from mod_kvhostlink import kvHostLink
import atexit


try:
    kv = kvHostLink('192.168.11.9')
    ###接続確認、接続がうまく行けばエラーが発生しない
    connection_check = kv.read('M0.U')

    print("OK")

except:
    #接続エラー時
    print("CONNECTION-ERROR")
    print("END")
    sys.exit()


#全接点の状態を格納
m = []

status = {"mode":"停止中","situation":"none"}

#全部の接点の状態を取得
for i in range(100):
    raw_data = kv.read('M{0}.U'.format(i))
    data= raw_data[0:5].decode("utf-8")
    m.append(data)
    #print('M{0}.U : {1}'.format(i,data))

for j in range(100):
    #接点がONのとき
    if(m[j] == '00001'):

        #エラー
        if(j == 0):
            status.update({"mode":"エラー"})
        if(status["mode"] == "エラー" and j != 0):
            if(j == 19):
                status.update({"situation":"長時間動作"})
            elif(j ==20):
                status.update({"situation":"運転切替"})
            elif(j ==21):
                status.update({"situation":"動作切替"})
            elif(j ==22):
                status.update({"situation":"原点復帰割込み"})
            else:
                status.update({"situation":"その他"})


        #連動運転
        if(j == 1):
            status.update({"mode":"連動運転"})
            status.update({"situation":"その他"})

        #単独運転
        if(2 <= j and j <= 4):
            print(j)
            status.update({"mode":"単独運転"})
            print("独立")
            if( j == 2 ):
                status.update({"situation":"ゲートカット"})
            elif( j == 3 ):
                status.update({"situation":"ゲートカット&画像検査"})
            elif( j == 4 ):
                status.update({"situation":"画像検査"})
            else:
                status.update({"situation":"その他"})

        #原点復帰
        if(j == 5):
            status.update({"mode":"連動運転"})
        if(status["mode"] == "連動運転" and j != 5):
            if(j == 6):
                status.update({"situation":"土台後退"})
            elif(j == 7):
                status.update({"situation":"エアニッパ原点右移動"})
            elif(j == 8):
                status.update({"situation":"エアニッパ原点右移動"})


print("モード：{0}".format(status["mode"]))
print("状況：{0}".format(status["situation"]))