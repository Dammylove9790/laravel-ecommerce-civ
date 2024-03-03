<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\auth\LoginMail;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    public function redirectTo()
    {
        if (Auth::user()->role === 'admin') {
            $this->redirectTo = 'users.admin.dashboard';
        } 
        // elseif (Auth::user()->role === 'farmer') {
        //     $this->redirectTo = 'users.farmer.dashboard';
        // } elseif (Auth::user()->role === 'buyer') {
        //     $this->redirectTo = 'users.buyer.dashboard';
        // } elseif (Auth::user()->role === 'logistics') {
        //     $this->redirectTo = 'users.logistics.dashboard';
        // } 
        else {
            $this->redirectTo = 'pages.index';
        }
        //Mail::to(Auth::user()->email)->send(new LoginMail(Auth::user()));
        return route($this->redirectTo);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}