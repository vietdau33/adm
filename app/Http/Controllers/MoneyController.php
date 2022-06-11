<?php

namespace App\Http\Controllers;

use App\Http\Services\MoneyService;
use App\Models\InvestmentBought;
use App\Models\MoneyModel;
use App\Models\Settings;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoneyController extends Controller
{
    public function home($page)
    {
        session()->flash('menu-active', 'money');
        return view('money.home', compact('page'));
    }

    public function deposit()
    {
        return $this->home('deposit');
    }

    public function withdraw()
    {
        return $this->home('withdraw');
    }

    public function transfer()
    {
        return $this->home('transfer');
    }

    private function transferToWallet(Request $request, $type): JsonResponse
    {
        if (empty($request->amount)) {
            return jsonError('Amount money transfer error!');
        }

        $amount = (double)$request->amount;
        if ($amount < 100) {
            return jsonError('Amount money minimum transfer is: 100');
        }

        try {
            $userMoney = user()->money;
            if ($amount > $userMoney->{$type}) {
                return jsonError("Amount money is bigger than money $type you have!");
            }

            $userMoney->{$type} -= $amount;
            $userMoney->wallet += $amount;
            $userMoney->save();

            return jsonSuccess('Transfer ' . ucfirst($type) . ' to Wallet success!');
        } catch (Exception $exception) {
            return jsonError("Cannot transfer $type to wallet. Please reload page and try again!");
        }
    }

    public function transferBonusToWallet(Request $request): JsonResponse
    {
        return $this->transferToWallet($request, 'bonus');
    }

    public function transferProfitToWallet(Request $request): JsonResponse
    {
        return $this->transferToWallet($request, 'profit');
    }

    public function buyInvestment(Request $request): JsonResponse
    {
        return MoneyService::buyInvestment($request);
    }
}
