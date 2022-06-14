<?php

use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;

Route::prefix('telegram')->group(function() {
    Route::get('updated-activity', [TelegramController::class, 'updatedActivity']);
    Route::get('contact', [TelegramController::class, 'contactForm']);
    Route::post('send-message', [TelegramController::class, 'sendMessage']);
});
