<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;

Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('', [AdminController::class, 'home'])->name('home');
    Route::get('list-member', [AdminController::class, 'listMember'])->name('list-member');
    Route::get('money', [AdminController::class, 'money'])->name('money');
    Route::get('money/{type}', [AdminController::class, 'money'])->name('money.with-type');
    Route::get('report', [AdminController::class, 'report'])->name('report');
    Route::get('report/{type}', [AdminController::class, 'report'])->name('report.with-type');
    Route::get('report-transfer', [AdminController::class, 'reportTransfer'])->name('report-transfer');
    Route::post('status-withdraw', [AdminController::class, 'changeStatusWithdraw'])->name('status.withdraw');

    Route::prefix('banner')->group(function() {
        Route::get('', [AdminController::class, 'banner'])->name('banner');
        Route::post('create', [AdminController::class, 'bannerCreate'])->name('banner.create');
        Route::post('delete', [AdminController::class, 'bannerDelete'])->name('banner.delete');
        Route::post('change-active', [AdminController::class, 'bannerChangeStatus'])->name('banner.active');
    });

    Route::prefix('link-mission')->group(function(){
        Route::get('', [AdminController::class, 'linkMission'])->name('link-mission');
        Route::post('create', [AdminController::class, 'linkMissionCreate'])->name('link-mission.create');
        Route::post('delete', [AdminController::class, 'linkMissionDelete'])->name('link-mission.delete');
        Route::post('change-active', [AdminController::class, 'linkMissionChangeStatus'])->name('link-mission.active');
    });

    Route::prefix('settings')->group(function() {
        Route::get('', [AdminController::class, 'settings'])->name('settings');
        Route::post('profit', [AdminController::class, 'saveSettingProfit'])->name('settings.profit.save');
        Route::post('bonus', [AdminController::class, 'saveSettingBonus'])->name('settings.bonus.save');
        Route::post('withdraw', [AdminController::class, 'saveSettingWithdraw'])->name('settings.withdraw.save');
    });
});

Route::post("/admin/save-system-setting", [AdminController::class, "saveSystemSetting"])->name("admin.settings.save-system-setting");
Route::post("/change-setting", [AdminController::class, "changeSetting"])->name("admin.change-setting.post");
Route::get("/request-liquidity", [AdminController::class, "requestLiquidity"])->name("admin.request-liquidity.get");
Route::post("/request-liquidity", [AdminController::class, "requestLiquidityPost"])->name("admin.request-liquidity.post");
Route::get("/internal-transfer/export", [ExportController::class, "internalTransferExport"])->name("admin.internal-transfer.export");
Route::get("/request-liquidity/export", [ExportController::class, "requestLiqudityExport"])->name("admin.request-liquidity.export");
Route::get("/crypto-deposit/export", [ExportController::class, "cryptoDepositExport"])->name("admin.crypto-deposit.export");
Route::get("/crypto-withdraw/export", [ExportController::class, "cryptoWithdrawExport"])->name("admin.crypto-withdraw.export");
Route::post("/crypto-withdraw/change-status", [AdminController::class, "requestCryptoWithdrawPost"])->name("admin.crypto-withdraw.change-status");
