<?php

namespace App\Http\Services;

use App\Models\BonusLogs;
use App\Models\InvestmentBought;
use App\Models\Settings;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Withdraw;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoneyService
{
    protected static $settings = null;

    public static function buyInvestment(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $amount = trim($request->amount ?? '');
            if (empty($amount)) {
                return jsonError('Amount cannot empty!');
            }

            $amount = (double)$amount;
            $type = $request->type;
            if (!in_array($type, ['bronze', 'silver', 'gold', 'platinum'])) {
                return jsonError('Package Investment not correct!');
            }

            $settingAll = Settings::getSettings();
            $setting = $settingAll['profit']->setting->{$type};

            $minAmount = (double)$setting->min_amount;
            if ($amount < $minAmount) {
                return jsonError("Amount minimum is: $minAmount");
            }

            $userMoney = user()->money;
            if ((double)$userMoney->wallet < $amount) {
                return jsonError('The amount left in the account is not enough to buy!');
            }

            $userMoney->wallet = (double)$userMoney->wallet - $amount;
            $userMoney->save();

            $investment = new InvestmentBought();
            $investment->user_id = user()->id;
            $investment->type = $type;
            $investment->money_buy = $amount;
            $investment->profit = $setting->profit;
            $investment->days = $setting->days;
            $investment->min_amount = $setting->min_amount;
            $investment->max_withdraw = $setting->max_withdraw;
            $investment->save();

            MoneyService::calcBonusInterest(user(), $amount);

            DB::commit();
            return jsonSuccess('You have successfully purchased the package! We\'ll do a page reload!');
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonError('There was an error during the purchase of the package. please reload the page and try again');
        }
    }

    protected static function getSettings($type)
    {
        if (self::$settings == null) {
            self::$settings = Settings::getSettings();
        }
        return self::$settings[$type]->setting;
    }

    private static function __callInterestBonus__(User $user, User $userFrom, int $level = 1, $money = 0): void
    {
        $settings = self::getSettings('bonus');
        $settingLevel = $settings->{"level_$level"} ?? null;

        if ($settingLevel == null) {
            return;
        }

        $countNumberF1 = User::countNumberF1ByRef($user->reflink);
        if ((int)$settingLevel->condition_f1 > $countNumberF1) {
            goto next_sibling;
        }

        $countInvestMoney = InvestmentBought::countInvestmentBoughtMoney($user->id);
        if($countInvestMoney < (double)$settings->minimum_to_bonus) {
            goto next_sibling;
        }

        $moneyBonus = $money * (double)$settingLevel->bonus / 100;
        $userMoney = $user->money;
        $userMoney->bonus += $moneyBonus;
        $userMoney->save();

        ModelService::insert(BonusLogs::class, [
            'user_id' => $user->id,
            'user_id_from' => $userFrom->id,
            'money' => $money,
            'rate' => (double)$settingLevel->bonus,
            'condition_f1' => (int)$settingLevel->condition_f1,
            'money_bonus' => $moneyBonus,
        ]);

        next_sibling:

        if ($level >= 5) {
            return;
        }

        $parentUser = User::whereReflink($user->upline_by)->first();
        if ($parentUser == null) {
            return;
        }

        self::__callInterestBonus__($parentUser, $userFrom, $level + 1, $money);
    }

    public static function calcBonusInterest(User $user, $money): void
    {
        $parentUser = User::whereReflink($user->upline_by)->first();
        if ($parentUser == null) {
            return;
        }
        self::__callInterestBonus__($parentUser, $user, 1, $money);
    }

    public static function transferToWallet(Request $request, $type): JsonResponse
    {
        if (empty($request->amount)) {
            return jsonError('Amount money transfer error!');
        }

        $amount = (double)$request->amount;
        //if ($amount < 100) {
        //    return jsonError('Amount money minimum transfer is: 100');
        //}

        DB::beginTransaction();
        try {
            $userMoney = user()->money;
            if ($amount > $userMoney->{$type}) {
                return jsonError("Amount money is bigger than money $type you have!");
            }

            $userMoney->{$type} -= $amount;
            $userMoney->wallet += $amount;
            $userMoney->save();

            DB::commit();
            return jsonSuccess('Transfer ' . ucfirst($type) . ' to Wallet success!');
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonError("Cannot transfer $type to wallet. Please reload page and try again!");
        }
    }

    public static function createWithdraw(Request $request): JsonResponse
    {
        if (empty($request->amount)) {
            return jsonError('Amount money withdraw error!');
        }
        $amount = (double)$request->amount;
        if ($amount > user()->money->wallet) {
            return jsonError('The withdraw amount is larger than the available amount!');
        }
        if($amount <= 20) {
            return jsonError('The withdraw amount minximum is: 20');
        }
        $maxWithdraw = Withdraw::getMaxWithdraw();
        if($amount > $maxWithdraw) {
            return jsonError('The withdraw amount maximum is: ' . $maxWithdraw);
        }
        if (empty($request->address)) {
            return jsonError('Address withdraw error!');
        }
        if (empty($request->get('2fa_code'))) {
            return jsonError('2FA code error!');
        }
        if (
            !app('pragmarx.google2fa')->verifyKey(
                user()->google2fa_secret,
                $request->get('2fa_code')
            )
        ) {
            return jsonError('Code 2FA verify not match!');
        }
        DB::beginTransaction();
        try {
            $userMoney = user()->money;
            $userMoney->wallet -= $amount;
            $userMoney->save();

            $withdraw = ModelService::insert(Withdraw::class, [
                'user_id' => user()->id,
                'amount' => $amount,
                'address' => $request->address
            ]);

            if($withdraw === false) {
                throw new Exception('');
            }

            DB::commit();
            TelegramService::sendMessageWithdraw([
                'username' => user()->username,
                'withdraw_id' => $withdraw->id,
                'amount' => $withdraw->amount,
                'address' => $withdraw->address,
            ]);
            return jsonSuccess('Create request withdraw success!');
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonError('Cannot create request withdraw! Please reload page and try again!');
        }
    }

    public static function createTransfer(Request $request): JsonResponse
    {
        if (empty($request->amount)) {
            return jsonError('Amount money transfer error!');
        }
        $amount = (double)$request->amount;
        if ($amount < 10) {
            return jsonError('The withdraw transfer minimum is: 10!');
        }
        if ($amount > user()->money->wallet) {
            return jsonError('The transfer amount is larger than the available amount!');
        }
        if (empty($request->username_receive)) {
            return jsonError('User Receive not found!');
        }
        if (empty($request->get('2fa_code'))) {
            return jsonError('2FA code error!');
        }
        if (
            !app('pragmarx.google2fa')->verifyKey(
                user()->google2fa_secret,
                $request->get('2fa_code')
            )
        ) {
            return jsonError('Code 2FA verify not match!');
        }
        $userReceive = User::whereUsername($request->username_receive)->first();
        if($userReceive == null) {
            return jsonError('User Receive not exists!');
        }
        if($userReceive->role == 'admin') {
            return jsonError('You cannot transfer to ADMIN!');
        }

        DB::beginTransaction();
        try {
            $userMoney = user()->money;
            $userMoney->wallet -= $amount;
            $userMoney->save();

            $userReceiveMoney = $userReceive->money;
            $userReceiveMoney->wallet += $amount;
            $userReceiveMoney->save();

            ModelService::insert(Transfer::class, [
                'user_id' => user()->id,
                'amount' => $amount,
                'username_receive' => $request->username_receive
            ]);

            DB::commit();
            return jsonSuccess('Transfer success!');
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonError('Cannot create request transfer! Please reload page and try again!');
        }
    }
    public static function adminCreateTransfer(Request $request): JsonResponse
    {
        if (empty($request->amount)) {
            return jsonError('Amount money transfer error!');
        }
        $amount = (double)$request->amount;
        if ($amount < 10) {
            return jsonError('The withdraw transfer minimum is: 10!');
        }
        if (empty($request->username_receive)) {
            return jsonError('User Receive not found!');
        }
        $userReceive = User::whereUsername($request->username_receive)->first();
        if($userReceive == null) {
            return jsonError('User Receive not exists!');
        }

        DB::beginTransaction();
        try {
            $userReceiveMoney = $userReceive->money;
            $userReceiveMoney->wallet += $amount;
            $userReceiveMoney->save();

            ModelService::insert(Transfer::class, [
                'user_id' => user()->id,
                'amount' => $amount,
                'username_receive' => $request->username_receive
            ]);

            DB::commit();
            return jsonSuccess('Transfer success!');
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonError('Cannot create request transfer! Please reload page and try again!');
        }
    }
}
