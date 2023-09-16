<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Individual User
        User::create([
            'name' => 'Individual User',
            'email' => 'xyz@email.com',
            'account_type' => 'Individual', // Enum value for Individual
            'balance' => 1000.55,
            'password' => Hash::make('password'), // password
        ]);

        // Business User
        User::create([
            'name' => 'Business User',
            'email' => 'business@example.com',
            'account_type' => 'Business', // Enum value for business
            'balance' => 1000.44,
            'password' => Hash::make('password'),
        ]);
    }
}
