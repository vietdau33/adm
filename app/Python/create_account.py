import json
import sys
import os
from web3 import Web3

url = 'https://mainnet.infura.io/v3/2b0d5ad9f5854ca5b8d168eb72477e91'

try:
    user_id = sys.argv[1]

    web3 = Web3(Web3.HTTPProvider(url))
    account = web3.eth.account.create()
    address = account.address
    privateKey = account.privateKey

    f = open(os.getcwd() + '/create_account_' + user_id + '.txt', 'a')
    f.write(address + ' ||| ' + privateKey.hex())
    f.close()

    print('Done')
except:
    print('Fail')
