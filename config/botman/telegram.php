<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Telegram Token
    |--------------------------------------------------------------------------
    |
    | Your Telegram bot token you received after creating
    | the chatbot through Telegram.
    |
    */
    'token' => env('TELEGRAM_BOT_TOKEN'),

    'bots' => [
        'mybot' => [
            'username'            => env('TELEGRAM_BOT', 'TelegramBot'),
            'token'               => env('TELEGRAM_BOT_TOKEN', ''),
            'certificate_path'    => env('TELEGRAM_CERTIFICATE_PATH', ''),
            'webhook_url'         => env('TELEGRAM_WEBHOOK_URL', ''),
            'commands'            => [
            ],
        ],
    ],
];
