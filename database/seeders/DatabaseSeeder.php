<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Testing\Fakes\Fake;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(10)->create([
            'name' => fake()->name(),
            'email' => fake()->unique(true)->safeEmail(),
            'email_verified_at' => now(),
            'is_valid_email' => true,
            'otp_code' => fake()->numberBetween(1000000,9999999),
            'password' => Hash::make('11111111'),
        ]);
    }
}
