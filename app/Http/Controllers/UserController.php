<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Http\Helpers\MailHelper;
use App\Http\Helpers\OtpHelpers;
use App\Http\Helpers\UserHelper;
use App\Models\CryptoDeposit;
use App\Models\CryptoWithdraw;
use App\Models\HistoryIb;
use App\Models\InternalTransferHistory;
use App\Models\SystemSetting;
use App\Models\TransferToAdmin;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\HistorySystemSetting;

class UserController extends Controller
{

    public function internationalTransfer(){
        return view("pages.international-transfer");
    }

    /**
     * @throws UserException
     */
    public function internalTransferPost(Request $request): JsonResponse
    {
        $email      = $request->email ?? '';
        $amount     = (int)($request->amount ?? 0);
        $note       = $request->note ?? "";
        $otp        = (int)($request->otp_code ?? 0);
        $otpKey     = $request->otp_key ?? "";

        $user = User::getUserByEmail($email, true);
        if($user == null){
            return jsonError("Username not exists!");
        }
        $username = $user->username;

        $maxTransfer = config('transfer.max-transfer', 0);
        if($amount <=0 || $amount > $maxTransfer){
            return jsonError("Amount value must be from 1 to $maxTransfer!");
        }

        if(Auth::user()->role == 'user' && $amount > Auth::user()->money_wallet){
            return jsonError("The amount transfer must be greater than 0 and less than the amount currently in the wallet. Currently " . Auth::user()->money_wallet);
        }

        if(!OtpHelpers::verify($otp, $otpKey, true)->status){
            return jsonError("OTP does not match or has expired!");
        }

        $logInternalTransfer = true;

        if($user->role == 'admin'){
            $statusValidateTime = User::validateTransferLiquidityTime();
            if($statusValidateTime !== true){
                return jsonError("The next payment is $statusValidateTime days left!");
            }
            User::transferToAdmin($user, [
                'amount' => $amount,
                'note' => $note
            ]);
            $logInternalTransfer = false;
        }else{
            $user->money_wallet = (int)$user->money_wallet + $amount;
            $user->save();
        }

        if(Auth::user()->role == 'user'){
            $userTransfer = User::getUserByUsername(Auth::user()->username);
            $userTransfer->money_wallet = (int)$userTransfer->money_wallet - $amount;
            $userTransfer->save();
        }

        if($logInternalTransfer){
            InternalTransferHistory::__insert([
                'userid' => Auth::user()->id,
                'to_username' => $username,
                'amount' => $amount,
                'note' => $note
            ]);
        }

        return jsonSuccess("Transfer to $email success!");
    }

    public function sendOtpTransfer(): JsonResponse
    {
        $otpGen = OtpHelpers::generate();
        $email  = Auth::user()->email;

        MailHelper::sendOtp([
            'email'     => $email,
            'fullname'  => Auth::user()->fullname,
            'otp'       => $otpGen->otp
        ], 'mail.transfer');

        return response()->json([
            'success' => true,
            'message' => "Send OTP success!",
            'data' => [
                'otp_key' => $otpGen->key
            ]
        ]);
    }

    public function internalTransferHistory(){
        $transferHistory = InternalTransferHistory::getHistory();
        return view('pages.internal-transfer-history', compact('transferHistory'));
    }

    /**
     * @throws UserException
     */
    public function transferToInvest(Request $request): JsonResponse
    {
        $amount = (int)($request->amount ?? 0);
        $maxTransfer = Auth::user()->money_wallet;
        if($amount < 999 || $amount > $maxTransfer){
            return jsonError("The amount transferred for investment must be greater than 1000 and less than the amount currently in the wallet. Currently $maxTransfer");
        }

        //get setting bonus
        $sysSetting = SystemSetting::buildSetting();
        $bonus = (int)$sysSetting->bonus / 100;

        //bonus 50% every time
        $user = User::getUserByUsername(Auth::user()->username);
        $user->invest_no_bonus  = (int)$user->invest_no_bonus + $amount;
        $user->money_invest     = (int)$user->money_invest + $amount + $amount * $bonus;
        $user->money_wallet     = (int)$user->money_wallet - $amount;
        $user->save();

        //get user upline
        $reflinkUserUpline = Auth::user()->upline_by;
        $userUpline = User::getUserByReflink($reflinkUserUpline);

        if((int)$userUpline->money_invest > 0){
            //bonus type 1: Khi đầu tư thì người giới thiệu mình sẽ được 50%
            $userUpline->money_invest = (int)$userUpline->money_invest + $amount * $bonus;
            $userUpline->save();

            //bonus type 2: Khi mình đầu tư nhiều hơn hoặc bằng invest của ng giới thiệu thì ng giới thiệu dc 50% invest của ng đó
            if($userUpline->bonus_received_type2 == 0 && $amount >= (int)$userUpline->invest_no_bonus){
                $userUpline->money_invest = (int)$userUpline->money_invest + (int)$userUpline->invest_no_bonus * $bonus;
                $userUpline->bonus_received_type2 = 1;
                $userUpline->save();
            }
        }

        //cộng tiền theo IB
        $superParent = json_decode($user->super_parent, 1);
        array_pop($superParent);
        $superParent = User::getUserByArrayReflink($superParent);
        $superParent = $superParent->filter(function($u){
            return $u->role != 'admin';
        });
        $superParent = $superParent->map(function($_u){
            return [
                'username' => $_u->username,
                'rate_ib' => (float)$_u->rate_ib
            ];
        })->reverse()->toArray();

        $reveiced = 0;
        foreach ($superParent as $parent){
            $reveicing = $parent['rate_ib'] - $reveiced;
            $logs = [
                'from' => $user->username,
                'to' => $parent['username'],
                'rate_ib_plus' => $reveicing,
            ];
            if($reveicing <= 0){
                $logs['is_continue'] = 1;
                goto log;
            }
            $_u = User::getUserByUsername($parent['username']);
            $_u->money_ib = (float)$_u->money_ib + $amount * $reveicing / 100;
            $_u->save();
            $reveiced += $reveicing;

            log :
            HistoryIb::__insert($logs);
        }

        return response()->json([
            'success' => true,
            'message' => "Transfer to invest success!",
            'data' => [
                'invest' => number_format((int)$user->money_invest, 2) . " £",
                'wallet' => number_format((int)$user->money_wallet, 2) . " £",
            ]
        ]);
    }

    /**
     * @throws UserException
     */
    public function transferIBToWallet(Request $request): JsonResponse
    {
        $amount = (int)($request->amount ?? 0);
        $maxTransfer = Auth::user()->money_ib;
        if($amount < 0 || $amount > $maxTransfer){
            return jsonError("The amount transferred for investment must be greater than 0 and less than the amount currently in the wallet. Currently $maxTransfer");
        }
        $user = User::getUserByUsername(Auth::user()->username);
        $user->money_wallet = (float)$user->money_wallet + $amount;
        $user->money_ib = (float)$user->money_ib - $amount;
        $user->save();
        return response()->json([
            'success' => true,
            'message' => "Transfer IB to wallet success!",
            'data' => [
                'ib' => number_format((float)$user->money_ib, 2) . " £",
                'wallet' => number_format((float)$user->money_wallet, 2) . " £",
            ]
        ]);
    }

    public function requestLiquidityHistory(){
        $listTransfer = TransferToAdmin::getListTransferHistory();
        return view('pages.request-liquidity-history', compact("listTransfer"));
    }

    /**
     * @throws UserException
     */
    public function getUserTree(Request $request){
        $username = $request->username ?? '';
        if($username == ''){
            return jsonError("Username has required!");
        }
        $user = User::getUserByUsername($username);
        $trees = User::buildTreeChildrent($user->reflink);
        return view('pages.user-tree', compact('trees'));
    }

    /**
     * @throws UserException
     */
    public function changeIB(Request $request): JsonResponse
    {
        if(Auth::user()->role != 'admin'){
            return jsonError("You cannot permission to change IB");
        }
        $username = $request->username ?? '';
        $user = User::getUserByUsername($username, true);
        if($user == null){
            return jsonError("User change IB not exists!");
        }
        if($user->role == 'admin'){
            return jsonError("Cannot set IB Rate to ADMIN!");
        }
        if($request->get('new_ib') == null){
            return jsonError("New IB has required!");
        }

        if(!is_numeric($request->new_ib)){
            return jsonError("The value of ib must be an integer or a real number greater than 0!");
        }

        $maxIB = (float)SystemSetting::getSetting("max-ib", "0");
        $maxIBUser = (float)SystemSetting::getSetting("max-ib-user", "0");
        $ib = (float)$request->new_ib;
        if($ib < 0 || $ib > $maxIBUser){
            return jsonError("The value of IB must be between 0 and $maxIBUser!");
        }

        //calc ib current to father
        $arySuperFather = json_decode($user->super_parent, 1);
        $ibRateFather = UserHelper::getIBRateWithArrayRef($arySuperFather, true);

        //calc ib current to child
        $aryStructUser = User::buildTreeChildrent($user->reflink);
        $tempAryIBFather = array_merge($ibRateFather, [$ib]);
        foreach ($aryStructUser as $struct){
            $struct = array_diff($struct, $arySuperFather);
            $structMerged = array_merge($arySuperFather, $struct);
            $structUsername = User::getStructUsernameWithReflink($structMerged);
            $tempIbFull = array_merge($tempAryIBFather, UserHelper::getIBRateWithArrayRef($struct));
            $sumIB = UserHelper::ibRateCalcType2($tempIbFull);
            $sumIBWithNotCurrent = UserHelper::ibRateCalcType2(array_merge($ibRateFather, $struct));
            if($sumIB > $maxIB){
                return UserHelper::returnErrorIBMax($maxIB - $sumIBWithNotCurrent, $structUsername);
            }
        }

        $user->rate_ib = $ib;
        $user->save();

        $tree = json_decode($request->tree, 1);
        $html = view('pages.user-tree.table', compact("tree"))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'html' => $html
            ],
            'message' => "Change IB success!"
        ]);
    }

    public function cryptoDeposit(){
        $rateCryptoSetting = SystemSetting::getRateCrypto();
        $methodCryptoSetting = SystemSetting::getSetting('crypto-method');
        $methodCryptoSetting = json_decode($methodCryptoSetting, 1);
        return view('pages.crypto-deposit', compact('rateCryptoSetting', 'methodCryptoSetting'));
    }

    public function cryptoWithDraw(){
        $rateCryptoSetting = SystemSetting::getRateCrypto();
        $methodCryptoSetting = SystemSetting::getSetting('crypto-method');
        $methodCryptoSetting = json_decode($methodCryptoSetting, 1);
        return view('pages.crypto-withdraw', compact('rateCryptoSetting', 'methodCryptoSetting'));
    }

    public function cryptoDepositPost(Request $request){
        $validator = Validator::make($request->all(), [
            'method'    => 'required',
            'rate'      => 'required',
            'amount'    => 'required',
            'from'      => 'required',
            'to'        => 'required',
            'txhash'    => 'required',
            'otp_code'  => 'required',
        ]);
        if ($validator->fails()) {
            return returnValidatorFail($validator);
        }
        $otp        = (int)($request->otp_code ?? 0);
        $otpKey     = $request->otp_key ?? "";
        if(!OtpHelpers::verify($otp, $otpKey, true)->status){
            return jsonError("OTP does not match or has expired!");
        }
        CryptoDeposit::__insert([
            'user_transfer' => Auth::user()->username,
            'method' => $request->get('method', ''),
            'rate'   => $request->get('rate', ''),
            'amount' => $request->get('amount', ''),
            'from'   => $request->get('from', ''),
            'to'     => $request->get('to', ''),
            'note'   => $request->get('note', ''),
            'txhash' => $request->get('txhash', ''),
        ]);

        return jsonSuccess("Deposit done!");
    }

    public function cryptoWithDrawPost(Request $request){
        $validator = Validator::make($request->all(), [
            'method'    => 'required',
            'rate'      => 'required',
            'amount'    => 'required',
            'to'        => 'required',
            'otp_code'  => 'required',
        ]);
        if ($validator->fails()) {
            return returnValidatorFail($validator);
        }
        $otp        = (int)($request->otp_code ?? 0);
        $otpKey     = $request->otp_key ?? "";
        if(!OtpHelpers::verify($otp, $otpKey, true)->status){
            return jsonError("OTP does not match or has expired!");
        }

        $userLogin = User::getUserByUsername(Auth::user()->username, true);

        if($userLogin == null){
            return jsonError("Cannot get user login");
        }

        $amount = $request->get('amount', 0);

        if((float)$userLogin->money_wallet < (float)$amount){
            return jsonError("Money wallet not enogth.");
        }

        $userLogin->money_wallet = (float)$userLogin->money_wallet - (float)$amount;
        $userLogin->save();

        CryptoWithdraw::__insert([
            'user_transfer' => Auth::user()->username,
            'method' => $request->get('method', ''),
            'rate'   => $request->get('rate', ''),
            'amount' => $request->get('amount', ''),
            'to'     => $request->get('to', ''),
            'note'   => $request->get('note', '')
        ]);

        return jsonSuccess("Withdraw done!");
    }

    public function cryptoDepositHistory(){
        $histories = CryptoDeposit::getHistory();
        return view('pages.crypto-deposit-history', compact('histories'));
    }

    public function cryptoDepositHistorySearch(Request $request, $model = null): JsonResponse
    {
        $size       = $request->get("size", 10);
        $username   = $request->get('username');
        $fromDate   = $request->get('from_date', '');
        $toDate     = $request->get('to_date', '');
        $isWithDraw = (bool)$request->get('is_withdraw', false);

        if($toDate != '' && $fromDate == ''){
            $fromDate = $toDate;
        }

        if($fromDate != ''){
            $fromDate = __d($fromDate, "Y/m/d") . " 00:00:00";
        }

        if($toDate != ''){
            $toDate = __d($toDate, "Y/m/d") . " 23:59:59";
        }

        $histories = $model ?? CryptoDeposit::where('id', ">", 0);

        if(Auth::user()->role != 'admin'){
            $username = Auth::user()->username;
        }

        if($username != null){
            $histories->where(['user_transfer' => $username]);
        }

        if($fromDate != '' && $toDate != ''){
            $histories->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $histories = $histories->get();

        $view = $isWithDraw ? "pages.crypto.withdraw-history-table" : "pages.crypto.deposit-history-table";

        $html = view($view, compact('histories'))->render();

        return response()->json([
            'success' => true,
            'message' => 'search success!',
            'typeSearch' => 'cripto-history',
            'data' => [
                'html' => $html
            ]
        ]);
    }

    public function cryptoWithdrawHistory(){
        $histories = CryptoWithdraw::getHistory();
        return view('pages.crypto-withdraw-history', compact('histories'));
    }


    public function cryptoWithdrawHistorySearch(Request $request): JsonResponse
    {
        $request->request->add(['is_withdraw' => true]);
        $model = CryptoWithdraw::where("id", ">", 0);
        return $this->cryptoDepositHistorySearch($request, $model);
    }

    public function requestLiquiditySearch(Request $request): JsonResponse
    {
        $size       = $request->get("size", 10);
        $username   = $request->get('username');
        $fromDate   = $request->get('from_date', '');
        $toDate     = $request->get('to_date', '');
        $isHistory  = (bool)$request->get('is_history', false);

        if($toDate != '' && $fromDate == ''){
            $fromDate = $toDate;
        }

        if($fromDate != ''){
            $fromDate = __d($fromDate, "Y/m/d") . " 00:00:00";
        }

        if($toDate != ''){
            $toDate = __d($toDate, "Y/m/d") . " 23:59:59";
        }

        if($isHistory){
            $liquidity = TransferToAdmin::where('status', "<>", 0);
        }else{
            $liquidity = TransferToAdmin::where(['status' => 0]);
        }

        if($username != null){
            $liquidity->where(['from' => $username]);
        }

        if($fromDate != '' && $toDate != ''){
            $liquidity->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $listTransfer = $liquidity->get();

        $view = 'pages.request-liquidity.table-list-pending';
        if($isHistory){
            $view = Auth::user()->role == 'admin' ? "pages.request-liquidity.admin" : "pages.request-liquidity.user";
        }

        $html = view($view, compact('listTransfer'))->render();

        return response()->json([
            'success' => true,
            'message' => 'search success!',
            'typeSearch' => 'liquidity',
            'data' => [
                'html' => $html
            ]
        ]);
    }

    /**
     * @throws UserException
     */
    public function internalTransferHistorySearch(Request $request): JsonResponse
    {
        $size       = $request->get("size", 10);
        $username   = $request->get('username');
        $fromDate   = $request->get('from_date', '');
        $toDate     = $request->get('to_date', '');

        if($toDate != '' && $fromDate == ''){
            $fromDate = $toDate;
        }

        if($fromDate != ''){
            $fromDate = __d($fromDate, "Y/m/d") . " 00:00:00";
        }

        if($toDate != ''){
            $toDate = __d($toDate, "Y/m/d") . " 23:59:59";
        }

        $internalTransfer = InternalTransferHistory::where('id', ">", 0);

        if($username != null){
            $user = User::getUserByUsername($username, 1);
            $internalTransfer->where(['to_username' => $username]);
            if($user != null){
                $internalTransfer->orWhere(['userid' => $user->id]);
            }
        }

        if($fromDate != '' && $toDate != ''){
            $internalTransfer->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $transferHistory = $internalTransfer->get();

        if(Auth::user()->role != 'admin'){
            $transferHistory = $transferHistory->filter(function($transfer){
                return $transfer->userid == Auth::user()->id || $transfer->to_username == Auth::user()->username;
            });
        }

        $html = view('pages.internal-transfer.history-table', compact('transferHistory'))->render();

        return response()->json([
            'success' => true,
            'message' => 'search success!',
            'typeSearch' => 'internal-transfer',
            'data' => [
                'html' => $html
            ]
        ]);
    }
    public function requestLiquidityHistorySearch(Request $request): JsonResponse
    {
        $request->request->add(['is_history' => true]);
        return $this->requestLiquiditySearch($request);
    }

    public function interestRateHistorySearch(Request $request): JsonResponse
    {
        $defaultSize = SystemSetting::getDefaultSizePagination();
        $size        = $request->get("size", $defaultSize);
        $fromDate    = $request->get('from_date', '');
        $toDate      = $request->get('to_date', '');

        if($toDate != '' && $fromDate == ''){
            $fromDate = $toDate;
        }

        if($fromDate != ''){
            $fromDate = __d($fromDate, "Y/m/d") . " 00:00:00";
        }

        if($toDate != ''){
            $toDate = __d($toDate, "Y/m/d") . " 23:59:59";
        }

        $interestHistory = HistorySystemSetting::where('id', ">", 0);
        if($fromDate != '' && $toDate != ''){
            $interestHistory->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $interestHistory = $interestHistory->orderBy("created_at", "DESC")->paginate($size);

        $html = view('pages.interest.interest-table-history-table', compact('interestHistory'))->render();

        return response()->json([
            'success' => true,
            'typeSearch' => 'interest-rate-history',
            'data' => [
                'html' => $html
            ]
        ]);
    }
    public function personalDetail(){
        session()->flash('menu-active', 'setting');
        return view("pages.personal-detail");
    }
    public function changePasswordView(){
        return view("pages.change-password");
    }
    public function personalDetailEdit(Request $request): JsonResponse
    {
        $params = $request->only(['fullname', 'phone', 'city']);
        if($params['fullname'] == '' || $params['phone'] == '' || $params['city'] == ''){
            return jsonError("Info save missing data!");
        }
        if (!preg_match("/^[a-zA-Z0-9-' ]*$/",$params['fullname'])) {
            return jsonError("Fullanme: Only letters and white space allowed!");
        }
        if (!preg_match("/^[0][0-9]{9,10}$/",$params['phone'])) {
            return jsonError("Fullanme: Phone not correct format!");
        }
        $user = User::getUserByEmail(Auth::user()->email);
        $user->fullname = $params['fullname'];
        $user->phone    = $params['phone'];
        $user->address  = [
            "city" => $params['city']
        ];
        $user->save();
        return jsonSuccess("Chane info success!");
    }
    public function uploadDocumentsView(){
        return view("pages.upload-documents.default");
    }
}
