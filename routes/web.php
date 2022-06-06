<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MoneyController;
use Illuminate\Support\Facades\Route;
use App\Http\Helpers\RouteHelper;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;

//Route::get('/', [HomeController::class, 'homePage'])->name("home-page");
Route::get('/', function(){
    return redirect()->route('home.page');
})->name("home-page");

Route::middleware('logined')->group(function(){
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

    Route::prefix('money')->name('money.')->group(function(){
        Route::get('/', [MoneyController::class, 'deposit'])->name('home');
        Route::get('/deposit', [MoneyController::class, 'deposit'])->name('deposit');
        Route::get('/transfer', [MoneyController::class, 'transfer'])->name('transfer');
        Route::get('/withdraw', [MoneyController::class, 'withdraw'])->name('withdraw');
    });
});

Route::middleware('is-admin')->group(function(){
    RouteHelper::requireRoute("admin");
});

Route::prefix('/auth')->group(function(){
    RouteHelper::requireRoute("auth");
});

Route::prefix('/social')->group(function(){
    RouteHelper::requireRoute("social");
});

Route::get('/ref/{reflink}', [HomeController::class, 'reflink'])->name("reflink");
