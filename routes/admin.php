<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;

Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('', [AdminController::class, 'home'])->name('home');
    Route::get('list-member', [AdminController::class, 'listMember'])->name('list-member');
    Route::get('money', [AdminController::class, 'money'])->name('money');
    Route::get('report-transfer', [AdminController::class, 'reportTransfer'])->name('report-transfer');
    Route::get('banner', [AdminController::class, 'banner'])->name('banner');
    Route::post('banner/create', [AdminController::class, 'bannerCreate'])->name('banner.create');
    Route::post('banner/delete', [AdminController::class, 'bannerDelete'])->name('banner.delete');
    Route::post('banner/change-active', [AdminController::class, 'bannerChangeStatus'])->name('banner.active');
    Route::get('settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('link-mission', [AdminController::class, 'linkMission'])->name('link-mission');
    Route::post('link-mission/create', [AdminController::class, 'linkMissionCreate'])->name('link-mission.create');
    Route::post('link-mission/delete', [AdminController::class, 'linkMissionDelete'])->name('link-mission.delete');
    Route::post('link-mission/change-active', [AdminController::class, 'linkMissionChangeStatus'])->name('link-mission.active');
});

//Route::get("/admin/settings", [AdminController::class, "settingsView"])->name("admin.settings.get");
Route::post("/admin/save-system-setting", [AdminController::class, "saveSystemSetting"])->name("admin.settings.save-system-setting");
Route::post("/change-setting", [AdminController::class, "changeSetting"])->name("admin.change-setting.post");
Route::get("/request-liquidity", [AdminController::class, "requestLiquidity"])->name("admin.request-liquidity.get");
Route::post("/request-liquidity", [AdminController::class, "requestLiquidityPost"])->name("admin.request-liquidity.post");
Route::get("/internal-transfer/export", [ExportController::class, "internalTransferExport"])->name("admin.internal-transfer.export");
Route::get("/request-liquidity/export", [ExportController::class, "requestLiqudityExport"])->name("admin.request-liquidity.export");
Route::get("/crypto-deposit/export", [ExportController::class, "cryptoDepositExport"])->name("admin.crypto-deposit.export");
Route::get("/crypto-withdraw/export", [ExportController::class, "cryptoWithdrawExport"])->name("admin.crypto-withdraw.export");
Route::post("/crypto-withdraw/change-status", [AdminController::class, "requestCryptoWithdrawPost"])->name("admin.crypto-withdraw.change-status");
