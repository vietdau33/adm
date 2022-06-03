<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;

Route::get("/admin/settings", [AdminController::class, "settingsView"])->name("admin.settings.get");
Route::post("/admin/save-system-setting", [AdminController::class, "saveSystemSetting"])->name("admin.settings.save-system-setting");
Route::post("/change-setting", [AdminController::class, "changeSetting"])->name("admin.change-setting.post");
Route::get("/request-liquidity", [AdminController::class, "requestLiquidity"])->name("admin.request-liquidity.get");
Route::post("/request-liquidity", [AdminController::class, "requestLiquidityPost"])->name("admin.request-liquidity.post");
Route::get("/internal-transfer/export", [ExportController::class, "internalTransferExport"])->name("admin.internal-transfer.export");
Route::get("/request-liquidity/export", [ExportController::class, "requestLiqudityExport"])->name("admin.request-liquidity.export");
Route::get("/crypto-deposit/export", [ExportController::class, "cryptoDepositExport"])->name("admin.crypto-deposit.export");
Route::get("/crypto-withdraw/export", [ExportController::class, "cryptoWithdrawExport"])->name("admin.crypto-withdraw.export");
Route::post("/crypto-withdraw/change-status", [AdminController::class, "requestCryptoWithdrawPost"])->name("admin.crypto-withdraw.change-status");
