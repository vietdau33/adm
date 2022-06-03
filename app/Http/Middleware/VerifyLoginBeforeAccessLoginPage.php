<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyLoginBeforeAccessLoginPage
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
        $aryUriRedirect = [
            'auth/login',
            'auth/register'
        ];
        if(Auth::check()){
            if($request->is($aryUriRedirect)){
                return redirect()->to('/home');
            }
            if(Auth::user()->verified && $request->is('auth/verify')){
                return redirect()->to('/home');
            }
        }
        return $next($request);
    }
}
