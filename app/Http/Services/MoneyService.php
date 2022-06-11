<?php

namespace App\Http\Services;

use App\Exceptions\UserException;
use App\Models\InvestmentBought;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoneyService
{
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

            $setting = Settings::getSettings()['profit']->setting->{$type};
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

            DB::commit();
            return jsonSuccess('You have successfully purchased the package! We\'ll do a page reload!');
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonError('There was an error during the purchase of the package. please reload the page and try again');
        }
    }

    public static function calcBonusInterest($user_id, $money)
    {
        $settings = Settings::getSettings()['bonus']->setting;
        $user = User::whereUserId($user_id)->first();
        if ($user == null) {
            return false;
        }
        $calcCallback = function ($level) use ($settings) {
            //
        };
    }
}
