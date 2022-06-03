<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get("/login", [AuthController::class, "loginView"])->name("auth.login.view");
Route::post("/login", [AuthController::class, "loginPost"])->name("auth.login.post");
Route::get("/register", [AuthController::class, "registerView"])->name("auth.register.view");
Route::post("/register", [AuthController::class, "registerPost"])->name("auth.register.post");
Route::get("/verify", [AuthController::class, "otpVerifyView"])->name("auth.verify.view");
Route::post("/verify", [AuthController::class, "otpVerifyPost"])->name("auth.verify.post");
Route::post("/re-send-otp", [AuthController::class, "reSendOtp"])->name("auth.resendotp.post");
Route::get("/logout", [AuthController::class, "logout"])->name("auth.logout.get");
Route::get("/forgot", [AuthController::class, "forgotPasswordView"])->name("auth.forgotpassword.get");
Route::post("/forgot", [AuthController::class, "forgotPasswordPost"])->name("auth.forgotpassword.post");
Route::post("/confirm-otp", [AuthController::class, "confirmOTPPost"])->name("auth.confirmotp.post");
Route::post("/edit-password-forgot", [AuthController::class, "editPasswordForgot"])->name("auth.editpasswordforgot.post");
Route::post("/edit-password", [AuthController::class, "changePasswordPost"])->name("auth.changepassword.post");
