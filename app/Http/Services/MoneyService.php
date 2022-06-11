<?php

namespace App\Http\Services;

use App\Exceptions\UserException;
use App\Models\BonusLogs;
use App\Models\InvestmentBought;
use App\Models\Settings;
use App\Models\User;
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
        if ($settingLevel->condition_f1 > $countNumberF1) {
            return;
        }

        $moneyBonus = $money * (double)$settingLevel->bonus / 100;
        $userMoney = $user->money;
        $userMoney->bonus += $moneyBonus;
        $userMoney->save();

        ModelService::insert(BonusLogs::class, [
            'user_id' => $user->id,
            'user_id_from' => $userFrom->id,
            'rate' => (double)$settingLevel->bonus,
            'condition_f1' => (int)$settingLevel->condition_f1,
            'money_bonus' => $moneyBonus,
        ]);

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
}
