import time
from socket import *
import struct
import datetime

BUFSIZE = 4096

class kvHostLink:
    addr = ()
    destfins = []
    srcfins = []
    port = 8501
    

    def __init__(self, host):
        self.addr = host, self.port

    def sendrecive(self, command):
        s = socket(AF_INET, SOCK_DGRAM)
        s.bind(('', self.port))
        s.settimeout(2)

        starttime = time.time()

        s.sendto(command, self.addr)
        #print("send:%r" % (command))
        rcvdata = s.recv(BUFSIZE)

        elapsedtime = time.time() - starttime
        #print ('receive: %r\t Length=%r\telapsedtime = %sms' % (rcvdata, len(rcvdata), str(elapsedtime * 1000)))
        #print()
        return rcvdata

    def mode(self, mode):
        senddata = 'M' + mode
        rcv = self.sendrecive((senddata + '\r').encode())
        return rcv

    def unittype(self):
        rcv = self.sendrecive("?k\r".encode())
        return rcv

    def errclr(self):
        senddata = 'ER'
        rcv = self.sendrecive((senddata + '\r').encode())
        return rcv

    def er(self):
        senddata = '?E'
        rcv = self.sendrecive((senddata + '\r').encode())
        return rcv

    def settime(self):
        dt_now = datetime.datetime.now()
        senddata = 'WRT ' + str(dt_now.year)[2:]
        senddata = senddata + ' ' + str(dt_now.month)
        senddata = senddata + ' ' + str(dt_now.day)
        senddata = senddata + ' ' + str(dt_now.hour)
        senddata = senddata + ' ' + str(dt_now.minute)
        senddata = senddata + ' ' + str(dt_now.second)
        senddata = senddata + ' ' + dt_now.strftime('%w')
        rcv = self.sendrecive((senddata + '\r').encode())
        return rcv
        
    def set(self, address):
        rcv = self.sendrecive(('ST ' + address + '\r').encode())
        return rcv

    def reset(self, address):
        rcv = self.sendrecive(('RS ' + address + '\r').encode())
        return rcv

    def sts(self, address, num):
        rcv = self.sendrecive(('STS ' + address + ' ' + str(num) + '\r').encode())
        return rcv

    def rss(self, address, num):
        rcv = self.sendrecive(('RSS ' + address + ' ' + str(num) + '\r').encode())
        return rcv

    def read(self, addresssuffix):
        rcv = self.sendrecive(('RD ' + addresssuffix + '\r').encode())
        return rcv

    def reads(self, addresssuffix, num):
        rcv = self.sendrecive(('RDS ' + addresssuffix + ' ' + str(num) + '\r').encode())
        return rcv

    def write(self, addresssuffix, data):
        rcv = self.sendrecive(('WR ' + addresssuffix + ' ' + data + '\r').encode())
        return rcv

    def writs(self, addresssuffix, num, data):
        rcv = self.sendrecive(('WRS ' + addresssuffix + ' ' + str(num) + ' ' + data + '\r').encode())
        return rcv

kv = kvHostLink('192.168.11.9')

###連続運転
data = kv.read('M0.U')
m0 = data[0:5].decode("utf-8")

###アラーム
data = kv.read('M22.U')
m22 = data[0:5].decode("utf-8")

if(m0 == "00000" and m22 == "00000"):
    print("停止中")
elif(m0 == "00001"):
    print("連動運転")
elif(m0 == "00002"):
    print("独立運転")
elif( m0 == "00000" and m22 == "00001"):
    print("エラー")
else:
    print("該当なし")
# #単独運転-ゲートカット
# data = kv.read('M1.U')
# print(data)

# #単独運転-ゲートカット＆画像検査
# data = kv.read('M2.U')
# print(data)

# #単独運転-画像検査
# data = kv.read('M3.U')
# print(data)

# #原点復帰
# data = kv.read('M7.U')
# print(data)

#アラーム
# data = kv.read('M22.U')
# print(data)

