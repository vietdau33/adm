<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckVerifyUser
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
        $urlAllow = [
            'auth/verify',
            'auth/logout',
            'auth/re-send-otp',
        ];
        //if not login
        if(!Auth::check()){
            goto next;
        }
        //if url is verify
        if($request->is($urlAllow)){
            goto next;
        }
        //if user pending verified
        if(Auth::user()->verified == 0){
            return redirect()->to('/auth/verify');
        }

        next:
        return $next($request);
    }
}
