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
                $text .= "<b>Url</b>: " . route('admin.money.with-type', ['type' => 'withdraw']);

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
}
