<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function home($page, $datas = [])
    {
        session()->flash('menu-active', 'settings');
        return view('settings.home', compact('page', 'datas'));
    }

    public function profile()
    {
        return $this->home('profile');
    }

    public function kyc_account()
    {
        return $this->home('kyc_account');
    }

    public function _2fa()
    {
        return $this->home('2fa');
    }

    public function change_password()
    {
        return $this->home('change_password');
    }

    public function kyc_withdraw()
    {
        return $this->home('kyc_withdraw');
    }

    public function kyc_withdraw_save(Request $request): JsonResponse
    {
        $token = $request->usdt_token;
        $code_2fa = $request->get('2fa_code');
        if (empty($token)) {
            return jsonError('USDT Token Address not correct!');
        }
        if (empty($code_2fa)) {
            return jsonError('2FA code error!');
        }
        $google2fa = app('pragmarx.google2fa');
        if (!$google2fa->verifyKey(user()->google2fa_secret, $code_2fa)) {
            return jsonError('Code 2FA verify not match!');
        }

        DB::beginTransaction();
        try {
            $user = user();
            $user->addr_crypto = $token;
            $user->save();

            DB::commit();
            return jsonSuccess('Add Address USDT success!');
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonError('Cannot save new address USDT. Please reload page and try again!');
        }
    }
}
