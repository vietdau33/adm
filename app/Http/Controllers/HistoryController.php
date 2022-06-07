<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function home($page)
    {
        session()->flash('menu-active', 'history');
        return view('history.home', compact('page'));
    }

    public function profit()
    {
        return $this->home('profit');
    }

    public function bonus()
    {
        return $this->home('bonus');
    }
}
