<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        User::create([
            'role' => 'admin',
            'name' => 'Admin Page',
            'slug' => 'admin',
            'email' => 'priccaddo@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'phone_number' => '+22504099410',
            'password' => Hash::make('Priccaddo12@'),
            'status' => 'successful',
        ]);
    }
}
