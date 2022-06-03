<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;

Route::get("/telegram", [SocialController::class, "telegram"]);
Route::post("/listen-chat-telegram", [SocialController::class, "listenChat"]);
