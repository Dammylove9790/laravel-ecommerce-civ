<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}