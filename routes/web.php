<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MoneyController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Helpers\RouteHelper;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;

//Route::get('/', [HomeController::class, 'homePage'])->name("home-page");
Route::get('/', function () {
    return redirect()->route('home.page');
})->name("home-page");

Route::post('generate-google-authen-serect', [AuthController::class, 'generateGoogleAuthenSerect'])->name('generate-gg-auth');
Route::post('enable-google-authen-serect', [AuthController::class, 'enable2FAAuthen'])->name('enable-gg-auth');
Route::post('deactive-google-authen-serect', [AuthController::class, 'deactive2FA'])->name('deactive-gg-auth');

Route::middleware('logined')->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name("home.page");
    Route::get('/user-list', [HomeController::class, 'userList'])->name('userlist');
    Route::post('/user-list/{parent}', [HomeController::class, 'userListHasParent'])->name('userlist.has_parent');
    Route::post('/user/search', [HomeController::class, 'searchUser'])->name('userlist.search');
    Route::post('/user/get-info/{ref}', [HomeController::class, 'getInfoUser'])->name('user.get-info');
    Route::get('/my-profile/personal-detail', [UserController::class, 'personalDetail'])->name('my-profile.personal-detail');
    Route::post('/my-profile/personal-detail/edit', [UserController::class, 'personalDetailEdit'])->name('my-profile.personal-detail.edit');
    Route::get('/my-profile/change-password', [UserController::class, 'changePasswordView'])->name('my-profile.change-password');
    Route::get('/my-profile/upload-documents', [UserController::class, 'uploadDocumentsView'])->name('my-profile.upload-document');
    Route::get('/international-transfer', [UserController::class, 'internationalTransfer'])->name('user.international-transfer.get');
    Route::post('/send-otp-transfer', [UserController::class, 'sendOtpTransfer'])->name('user.send-otp-transfer.post');
    Route::post('/submit-transfer', [UserController::class, 'internalTransferPost'])->name('user.submit-transfer.post');
    Route::get('/internal-transfer-history', [UserController::class, 'internalTransferHistory'])->name('user.internal-transfer-history.get');
    Route::post('/internal-transfer-history/search', [UserController::class, 'internalTransferHistorySearch'])->name('user.internal-transfer-search.post');
    Route::post('/transfer-to-invest', [UserController::class, 'transferToInvest'])->name('user.transfer-to-invest.post');
    Route::post('/transfer-ib-to-wallet', [UserController::class, 'transferIBToWallet'])->name('user.transfer-ib-to-wallet.post');
    Route::get("/request-liquidity-history", [UserController::class, "requestLiquidityHistory"])->name("user.request-liquidity-history.get");
    Route::post("/request-liquidity/search", [UserController::class, "requestLiquiditySearch"])->name("user.request-liquidity-search.post");
    Route::post("/request-liquidity-history/search", [UserController::class, "requestLiquidityHistorySearch"])->name("user.request-liquidity-history-search.post");
    Route::get("/user-tree/{username}", [UserController::class, "getUserTree"])->name("user.user-tree.get");
    Route::post("/change-ib", [UserController::class, "changeIB"])->name("user.change-ib.post");
    Route::get("/crypto-deposit", [UserController::class, "cryptoDeposit"])->name("user.crypto-deposit.get");
    Route::get("/crypto-withdraw", [UserController::class, "cryptoWithDraw"])->name("user.crypto-withdraw.get");
    Route::post("/crypto-deposit", [UserController::class, "cryptoDepositPost"])->name("user.crypto-deposit.post");
    Route::post("/crypto-withdraw", [UserController::class, "cryptoWithDrawPost"])->name("user.crypto-withdraw.post");
    Route::get("/crypto-deposit-history", [UserController::class, "cryptoDepositHistory"])->name("user.crypto-deposit-history.get");
    Route::post("/crypto-deposit-history/search", [UserController::class, "cryptoDepositHistorySearch"])->name("user.crypto-deposit-history-search.post");
    Route::get("/crypto-withdraw-history", [UserController::class, "cryptoWithdrawHistory"])->name("user.crypto-withdraw-history.get");
    Route::post("/crypto-withdraw-history/search", [UserController::class, "cryptoWithdrawHistorySearch"])->name("user.crypto-withdraw-history-search.post");
    Route::post("/interest-rate-history/search", [UserController::class, "interestRateHistorySearch"])->name("user.interest-rate-history-search.post");

    Route::prefix('money')->name('money.')->group(function () {
        Route::get('/', [MoneyController::class, 'deposit'])->name('home');
        Route::get('/deposit', [MoneyController::class, 'deposit'])->name('deposit');
        Route::get('/transfer', [MoneyController::class, 'transfer'])->name('transfer');
        Route::get('/withdraw', [MoneyController::class, 'withdraw'])->name('withdraw');
    });

    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/', [HistoryController::class, 'profit'])->name('home');
        Route::get('/profit', [HistoryController::class, 'profit'])->name('profit');
        Route::get('/bonus', [HistoryController::class, 'bonus'])->name('bonus');
    });

    Route::prefix('settings')->name('setting.')->group(function () {
        Route::get('/', [SettingController::class, 'profile'])->name('home');
        Route::get('/profile', [SettingController::class, 'profile'])->name('profile');
        Route::get('/kyc_account', [SettingController::class, 'kyc_account'])->name('kyc_account');
        Route::get('/2fa', [SettingController::class, '_2fa'])->name('2fa');
        Route::get('/change_password', [SettingController::class, 'change_password'])->name('change_password');
        Route::get('/kyc_withdraw', [SettingController::class, 'kyc_withdraw'])->name('kyc_withdraw');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::prefix('transfer')->name('transfer.')->group(function(){
            Route::post('bonus', [MoneyController::class, 'transferBonusToWallet'])->name('bonus');
            Route::post('profit', [MoneyController::class, 'transferProfitToWallet'])->name('profit');
        });
    });
});

Route::middleware('is-admin')->group(function () {
    RouteHelper::requireRoute("admin");
});

Route::prefix('/auth')->group(function () {
    RouteHelper::requireRoute("auth");
});

Route::prefix('/social')->group(function () {
    RouteHelper::requireRoute("social");
});

Route::get('/ref/{reflink}', [HomeController::class, 'reflink'])->name("reflink");
