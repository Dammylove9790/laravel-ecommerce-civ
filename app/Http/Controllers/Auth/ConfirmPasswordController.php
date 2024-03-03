<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}