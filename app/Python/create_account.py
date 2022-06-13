import json
import mysql.connector
import sys
from web3 import Web3

url = 'https://mainnet.infura.io/v3/2b0d5ad9f5854ca5b8d168eb72477e91'

try:
    user_id = sys.argv[1]

    mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        password="cdmllove",
        database="adm_db"
    )
    mycursor = mydb.cursor()
    sql = "INSERT INTO user_usdt (user_id, token, private_key) VALUES (%d, %s, %s)"

    web3 = Web3(Web3.HTTPProvider(url))
    account = web3.eth.account.create()
    address = account.address
    privateKey = account.privateKey.hex()

    val = (int(user_id), address, privateKey)
    mycursor.execute(sql, val)
    mydb.commit()

    print('Done')
except:
    print('Fail')
