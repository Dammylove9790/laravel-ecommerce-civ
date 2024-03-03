<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo;

    public function redirectTo()
    {
        if (Auth::user()->role === 'admin') {
            $this->redirectTo = 'users.admin.dashboard';
        } elseif (Auth::user()->role === 'farmer') {
            $this->redirectTo = 'users.farmer.dashboard';
        } elseif (Auth::user()->role === 'buyer') {
            $this->redirectTo = 'users.buyer.dashboard';
        } elseif (Auth::user()->role === 'logistics') {
            $this->redirectTo = 'users.logistics.dashboard';
        } else {
            $this->redirectTo = 'pages.index';
        }
        return route($this->redirectTo);
    }
}