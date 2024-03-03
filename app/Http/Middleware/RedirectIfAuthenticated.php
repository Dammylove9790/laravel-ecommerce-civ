<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (Auth::user()->role === 'admin') {
                    return redirect()->route('users.admin.dashboard');
                    // ->with('already_login', "You are already logged in. You can kindly logout");
                } 
                // elseif (Auth::user()->role === 'farmer') {
                //     return redirect()->route('users.farmer.dashboard');
                // } elseif (Auth::user()->role === 'buyer') {
                //     return redirect()->route('users.buyer.dashboard');
                // } elseif (Auth::user()->role === 'logistics') {
                //     return redirect()->route('users.logistics.dashboard');
                // }
                 else {
                    return redirect()->route('pages.index');
                }
                // return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}