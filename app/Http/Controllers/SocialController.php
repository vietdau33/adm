<?php

namespace App\Http\Controllers;

use App\Http\Helpers\TelegramHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Keyboard\Keyboard;

class SocialController extends Controller
{
    public function telegram(){
        $telegram = new Api(env("TELEGRAM_BOT_TOKEN"));
        $response = $telegram->sendMessage(['chat_id' => '1238975780', 'text' => rand(10000, 90999999)]);
        dd($response);
    }

    /**
     * @param Request $request
     * @throws TelegramSDKException
     */
    public function listenChat(Request $request){
        $mesage = $request->message;
        $chatId = $mesage['chat']['id'];
        $telegram = new TelegramHelper($chatId);

        Logger($request->message);

        if(isset($mesage['contact'])){
            //
        }

        switch (trim($mesage['text'] ?? "")){
            case '/otp' :
                $telegram->sendRequestGetPhone();
                break;
            case "/test" :
                $telegram->sendMessage("Helloooo ny nhớ");
                break;
        }
    }
}

