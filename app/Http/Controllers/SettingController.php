<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function home($page, $datas = []) {
        session()->flash('menu-active', 'settings');
        return view('settings.home', compact('page', 'datas'));
    }

    public function profile(){
        return $this->home('profile');
    }

    public function kyc_account(){
        return $this->home('kyc_account');
    }
    public function _2fa(){
        return $this->home('2fa');
    }
    public function change_password(){
        return $this->home('change_password');
    }
    public function kyc_withdraw(){
        return $this->home('kyc_withdraw');
    }
}
