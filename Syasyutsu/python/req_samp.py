import mysql.connector
import os
import subprocess
import random
import datetime


# DB 接続情報
conn = mysql.connector.connect(
    host="192.168.50.155",      # MariaDB サーバーのホスト
    user="laravel_user",      # MariaDB ユーザー
    password="web",  # MariaDB パスワード
    database="Syasyutsu"   # データベース名
)

cursor = conn.cursor()

# 送信データ作成
home_dir = os.path.expanduser('~')
result = subprocess.run(["bash", home_dir+"/dummy.sh"], capture_output=True, text=True)
res_length, res_width, res_height = result.stdout[2:7], result.stdout[10:15], result.stdout[19:24]
random_judg = random.randint(0,1)
datePart = datetime.datetime.now()
date = f'{datePart.year}-{datePart.month}-{datePart.day} {datePart.hour}:{datePart.minute}:{datePart.second}'

# 送信データ
width = float(res_width)
length = float(res_length)
height = float(res_height)
judgment = random_judg
created_at = date

# INSERT 文
sql = """
INSERT INTO logs (width, length, height, judgment, created_at)
VALUES (%s, %s, %s, %s, %s)
"""
values = (width, length, height, judgment, created_at)

cursor.execute(sql, values)
conn.commit()

print("送信成功, ID:", cursor.lastrowid)

cursor.close()
conn.close()
