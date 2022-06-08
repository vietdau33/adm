<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check() && !$request->is('auth/login')){
            return redirect()->to('/auth/login');
        }
        if(is_admin()) {
            return redirect()->to('/admin');
        }
        return $next($request);
    }
}
