import requests
import base58
import base64
from pprint import pprint

ADDRESS = "0x8CC88c1a15eBb6832c6b5085088E5DE67154a37e"
PRIV_KEY = '0xec94c9bfad49c22636edd06ed2c5e7a243a831e7161107f616c51dd9aa876638'

CONTRACT = "TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t"  # USDT

API_URL_BASE = 'https://api.trongrid.io/'
# API_URL_BASE = 'https://api.shasta.trongrid.io/'
# API_URL_BASE = 'https://api.nileex.io/'

METHOD_BALANCE_OF = 'balanceOf(address)'

METHOD_TRANSFER = 'transfer(address,uint256)'


DEFAULT_FEE_LIMIT = 1_000_000  # 1 TRX


def address_to_parameter(addr):
    return "0" * 24 + base58.b58decode_check(addr)[1:].hex()


def amount_to_parameter(amount):
    return '%064x' % amount


def get_balance(address=ADDRESS):
    url = API_URL_BASE + 'wallet/triggerconstantcontract'
    payload = {
        'owner_address': ADDRESS,
        'contract_address': base58.b58decode_check(CONTRACT).hex(),
        'function_selector': METHOD_BALANCE_OF,
        'parameter': address,
    }
    resp = requests.post(url, json=payload)
    data = resp.json()

    if data['result'].get('result', None):
        print(data['constant_result'])
        val = data['constant_result'][0]
        print('balance =', int(val, 16))
    else:
        print('error:', bytes.fromhex(data['result']['message']).decode())


def get_trc20_transaction(to, amount, memo=''):
    url = API_URL_BASE + 'wallet/triggersmartcontract'
    payload = {
        'owner_address': base58.b58decode_check(ADDRESS).hex(),
        'contract_address': base58.b58decode_check(CONTRACT).hex(),
        'function_selector': METHOD_TRANSFER,
        'parameter': address_to_parameter(to) + amount_to_parameter(amount),
        "fee_limit": DEFAULT_FEE_LIMIT,
        'extra_data': base64.b64encode(memo.encode()).decode(),  # TODO: not supported yet
    }
    resp = requests.post(url, json=payload)
    data = resp.json()

    if data['result'].get('result', None):
        transaction = data['transaction']
        return transaction

    else:
        print('error:', bytes.fromhex(data['result']['message']).decode())
        raise RuntimeError


def sign_transaction(transaction, private_key=PRIV_KEY):
    url = API_URL_BASE + 'wallet/addtransactionsign'
    payload = {'transaction': transaction, 'privateKey': private_key}
    resp = requests.post(url, json=payload)

    data = resp.json()

    if 'Error' in data:
        print('error:', data)
        raise RuntimeError
    return data


def broadcast_transaction(transaction):
    url = API_URL_BASE + 'wallet/broadcasttransaction'
    resp = requests.post(url, json=transaction)

    data = resp.json()
    print(data)


def transfer(to, amount, memo=''):
    transaction = get_trc20_transaction(to, amount, memo)
    pprint(transaction)
    transaction = sign_transaction(transaction)
    broadcast_transaction(transaction)


get_balance()
