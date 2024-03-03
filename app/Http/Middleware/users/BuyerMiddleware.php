<?php

namespace App\Http\Middleware\users;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('users.admin.dashboard');
            } elseif (Auth::user()->role == 'farmer') {
                return redirect()->route('users.farmer.dashboard')->with('unauthorized', 'You are redirected because you are not authorized to view the page you requested');
            } elseif (Auth::user()->role == 'buyer') {
                return $next($request);
            } elseif (Auth::user()->role == 'logistics') {
                return redirect()->route('users.logistics.dashboard')->with('unauthorized', 'You are redirected because you are not authorized to view the page you requested');
            } else {
                return redirect()->route('pages.index')->with('unauthorized', 'You are redirected because you are not authorized to view the page you requested');
            }
        }
    }
}