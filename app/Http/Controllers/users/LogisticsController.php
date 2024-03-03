<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogisticsController extends Controller
{
    public function index()
    {
        // return view('users.logistics.pages.dashboard');
        return "hello logistics";
    }
}