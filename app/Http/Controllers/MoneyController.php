<?php

namespace App\Http\Controllers;

use App\Http\Services\MoneyService;
use App\Models\Withdraw;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        //return $this->withdraw();
    }

    public function withdraw()
    {
        return $this->home('withdraw');
    }

    public function transfer()
    {
        return $this->home('transfer');
    }

    public function withdrawPost(Request $request): JsonResponse
    {
        return MoneyService::createWithdraw($request);
    }

    public function transferPost(Request $request): JsonResponse
    {
        if (is_admin()) {
            return MoneyService::adminCreateTransfer($request);
        }
        return MoneyService::createTransfer($request);
    }

    public function transferBonusToWallet(Request $request): JsonResponse
    {
        return MoneyService::transferToWallet($request, 'bonus');
    }

    public function transferProfitToWallet(Request $request): JsonResponse
    {
        return MoneyService::transferToWallet($request, 'profit');
    }

    public function buyInvestment(Request $request): JsonResponse
    {
        return MoneyService::buyInvestment($request);
    }
}
