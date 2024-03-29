<?php

namespace App\Http\Controllers\Auth;

use App\Mail\auth\RegistrationMail;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo;

    public function redirectTo()
    {
        $this->redirectTo = 'login';
        return route($this->redirectTo);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'role' => ['required', 'string'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_num' => ['required', 'numeric', 'unique:users,phone_number'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $fullName = ucfirst(strtolower($data['first_name'])) . ' ' . ucfirst(strtolower($data['last_name']));
        $slug = str_replace(' ', '-', $fullName) . strtotime('now');
        $status = 'pending';

        $new_reg = User::create([
            'role' => strtolower($data['role']),
            'name' => $fullName,
            'slug' => $slug,
            'email' => strtolower($data['email']),
            'phone_number' => $data['phone_num'],
            'password' => Hash::make($data['password']),
            'status' => $status
        ]);

        //Mail::to($data['email'])->send(new RegistrationMail($new_reg));

        return $new_reg;
    }
}