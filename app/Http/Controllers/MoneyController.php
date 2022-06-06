<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoneyController extends Controller
{
    public function home($page)
    {
        session()->flash('menu-active', 'money');
        return view('money.home', compact('page'));
    }

    public function deposit() {
        return $this->home('deposit');
    }

    public function withdraw() {
        return $this->home('withdraw');
    }

    public function transfer() {
        return $this->home('transfer');
    }
}
