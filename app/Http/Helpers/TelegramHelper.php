<?php

namespace App\Http\Helpers;

use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Keyboard\Keyboard;

class TelegramHelper {
    protected $app;
    protected $chatId;

    /**
     * TelegramHelper constructor.
     * @param $chatId
     * @throws TelegramSDKException
     */
    public function __construct($chatId){
        $this->app      = new Api(env("TELEGRAM_BOT_TOKEN"));
        $this->chatId   = $chatId;
        return $this->app;
    }

    /**
     * @param $message
     * @return \Telegram\Bot\Objects\Message
     * @throws TelegramSDKException
     */
    public function sendMessage($message){
        return $this->app->sendMessage(['chat_id' => $this->chatId, 'text' => $message]);
    }

    /**
     * @return \Telegram\Bot\Objects\Message
     * @throws TelegramSDKException
     */
    public function sendRequestGetPhone(){
        $btn = Keyboard::button([
            'text'              => 'Share Contact',
            'request_contact'   => true,
        ]);

        $keyboard = Keyboard::make([
            'keyboard'          => [[$btn]],
            'resize_keyboard'   => true,
            'one_time_keyboard' => true
        ]);

        return $this->app->sendMessage([
            'chat_id'       => $this->chatId,
            'text'          => 'Please click on share your contact for us.',
            'reply_markup'  => $keyboard
        ]);
    }
}
