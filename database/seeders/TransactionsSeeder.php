<?php

namespace Database\Seeders;

use App\Enums\Type;
use App\Models\Transactions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed individual transaction
        Transactions::create([
            'user_id' => 1, // Replace with the user ID
            'transaction_type' => Type::Individual, // Enum value for individual
            'amount' => 100.55,
            'fee' => 5.00,
            'date' => now(),
        ]);

        // Seed business transaction
        Transactions::create([
            'user_id' => 2, // Replace with the user ID
            'transaction_type' => Type::Business, // Enum value for business
            'amount' => 500.66,
            'fee' => 10.00,
            'date' => now(),
        ]);
    }
}
