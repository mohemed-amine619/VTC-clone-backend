<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('11111111'),
            'role' =>User::Admin_Role,
            'otp_code' => rand(10000000 , 99999999),
            'is_valid_email' => true, 
            'email_verified_at' => now()
        ]);
    }
}
