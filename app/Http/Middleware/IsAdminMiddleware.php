<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdminMiddleware
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
        if(is_admin()){
            return $next($request);
        }
        if(!logined()) {
            session()->put('prev_path', '/' . request()->path());
            return redirect()->to('/auth/login');
        }
        if(!$request->ajax()){
            return redirect()->to('/home');
        }
        return response()->json([
            'success'   => false,
            'message'   => "You not a Admin!",
            'redirect'  => 'home'
        ]);
    }
}
