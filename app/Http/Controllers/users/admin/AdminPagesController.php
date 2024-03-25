<?php

namespace App\Http\Controllers\users\admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\auth\AcceptUser;
use App\Mail\auth\DeleteUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AdminRegisterUserRequest;

class AdminPagesController extends Controller
{
    public function index()
    {
        $users = User::all()->sortByDesc('id');
        $products = Product::with('picture')->orderByDesc('id')->get();

        $orders = Order::all()->sortByDesc('id');

        return view('users.admin.pages.dashboard', compact(['users', 'products', 'orders']));
    }

    public function showUser($id)
    {
        $user = User::where('slug', $id)->firstOrFail();
        return view('users.admin.pages.users.showUser', compact('user'));
    }

    public function acceptUser($id)
    {
        $user = User::where('slug', $id)->firstOrFail();
        $user->update([
            'status' => 'successful'
        ]);
        //Mail::to($user->email)->send(new AcceptUser($user));
        return redirect()->route('users.admin.dashboard')->with('success', 'User has been accepted successfully');
    }

    public function deleteUser($id)
    {
        $user = User::where('slug', $id)->firstOrFail();
        $user->delete();
      //  Mail::to($user->email)->send(new DeleteUser($user));
        return redirect()->route('users.admin.dashboard')->with('success', 'User has been deleted successfully');
    }

    public function registerUser()
    {
        return view('users.admin.pages.users.registerUser');
    }

    public function storeUser(AdminRegisterUserRequest $request)
    {
        $fullName = ucfirst(strtolower($request->first_name)) . ' ' . ucfirst(strtolower($request->last_name));
        $slug = str_replace(' ', '-', $fullName) . strtotime('now');
        $status = 'successful';

        User::create([
            'role' => strtolower($request->role),
            'name' => $fullName,
            'slug' => $slug,
            'email' => strtolower($request->email),
            'phone_number' => $request->phone_num,
            'password' => Hash::make($request->password),
            'status' => $status
        ]);
        return redirect()->route('users.admin.dashboard')->with('success', 'User has been registered successfully');
    }

    public function manageAdmin()
    {
        $admins = User::where('role', 'admin')->orderByDesc('id')->get();
        return view('users.admin.pages.users.manageAdmin', compact('admins'));
    }

    public function manageBuyer()
    {
        $buyers = User::where('role', 'buyer')->orderByDesc('id')->get();
        return view('users.admin.pages.users.manageBuyer', compact('buyers'));
    }

    public function manageFarmer()
    {
        $farmers = User::where('role', 'farmer')->orderByDesc('id')->get();
        return view('users.admin.pages.users.manageFarmer', compact('farmers'));
    }

    public function manageLogistics()
    {
        $logistics = User::where('role', 'logistics')->orderByDesc('id')->get();
        return view('users.admin.pages.users.manageLogistics', compact('logistics'));
    }

    public function account(){
        $user = Auth::user();
        return view('users.admin.pages.account', compact('user'));
    }

    public function updatePassword(Request $request){
        $user = Auth::user();

        $request->validate([
            'current_password' => [
                'required', 'string', function($attribute, $value, $fail) use($request, $user) {
                    if (!Hash::check($request->current_password, $user->password)) {
                        $fail("Incorrect current password");
                    }
                }
            ],
            'new_password' => 'required|string|min:8|max:12|confirmed'
        ]);

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);    

        return redirect()->back()->with('success', 'Password updated successfully');

    }

}