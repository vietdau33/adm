<?php

namespace App\Http\Services;

use Exception;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramService {
    public static function sendMessageWithdraw($params): void
    {
        $try = 0;
        do {
            try{
                $text = "There is a new withdrawal request\n<b>Username: </b>" . $params['username'] . "\n";
                $text .= '<b>Amount</b>: ' . $params['amount'] . "\n";
                $text .= '<b>Wallet</b>: ' . $params['address'] . "\n";
                $text .= "<b>Url</b>: " . route('admin.money.with-type', ['type' => 'withdraw']) . '?withdraw_id=' . $params['withdraw_id'];

                Telegram::sendMessage([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
                    'parse_mode' => 'HTML',
                    'text' => '========NEW=====WITHDRAW========'
                ]);
                Telegram::sendMessage([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
                    'parse_mode' => 'HTML',
                    'text' => $params['address']
                ]);
                Telegram::sendMessage([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
                    'parse_mode' => 'HTML',
                    'text' => $text
                ]);
                break;
            }catch (Exception $exception) {
                $try++;
            }
        }while($try <= 3);
    }

    public static function sendMessageDeposit($params): void
    {
        $try = 0;
        do {
            try{
                $text = "There is a new deposit request\n<b>Username: </b>" . $params['username'] . "\n";
                $text .= '<b>Amount</b>: ' . $params['amount'] . "\n";
                $text .= '<b>Hash</b>: ' . $params['hash'] . "\n";
                $text .= '<b>From Wallet</b>: ' . $params['from'];

                Telegram::sendMessage([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID_DEPOSIT', ''),
                    'parse_mode' => 'HTML',
                    'text' => '========NEW=====DEPOSIT========'
                ]);
                Telegram::sendMessage([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID_DEPOSIT', ''),
                    'parse_mode' => 'HTML',
                    'text' => $text
                ]);
                break;
            }catch (Exception $exception) {
                $try++;
            }
        }while($try <= 3);
    }

    public static function sendMessageNewUser($params): void
    {
        $try = 0;
        do {
            try{
                $text = "New user just created!\n<b>Username: </b>" . $params['username'];
                Telegram::sendMessage([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID_DEPOSIT', ''),
                    'parse_mode' => 'HTML',
                    'text' => '========NEW=====USER========'
                ]);
                Telegram::sendMessage([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID_DEPOSIT', ''),
                    'parse_mode' => 'HTML',
                    'text' => $text
                ]);
                break;
            }catch (Exception $exception) {
                $try++;
            }
        }while($try <= 3);
    }
}
