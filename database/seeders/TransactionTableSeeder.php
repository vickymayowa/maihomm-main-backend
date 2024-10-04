<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserTransaction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(72);

        $transactions = [
            [
                'user_id' => $user->id,
                'currency_id' => 3,
                'fees' => rand(1000, 10000),
                'amount' => rand(1000, 10000),
                'description' => "This transaction is a test transaction ",
                'activity' => 'REFERRAL_BONUS',
                'reference' => "RF_".rand(1000, 10000),
                'type' => 'Credit',
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Completed",
            ],
            [
                'user_id' => $user->id,
                'currency_id' => 3,
                'fees' => rand(1000, 10000),
                'amount' => rand(1000, 10000),
                'description' => "This transaction is a test transaction ",
                'activity' => 'REFERRAL_BONUS',
                'reference' => "RF_".rand(1000, 10000),
                'type' => 'Credit',
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Completed",
            ],
            [
                'user_id' => $user->id,
                'currency_id' => 3,
                'fees' => rand(1000, 10000),
                'amount' => rand(1000, 10000),
                'description' => "This transaction is a test transaction ",
                'activity' => 'REFERRAL_BONUS',
                'reference' => "RF_".rand(1000, 10000),
                'type' => 'Credit',
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Completed",
            ],
            [
                'user_id' => $user->id,
                'currency_id' => 3,
                'fees' => rand(1000, 10000),
                'amount' => rand(1000, 10000),
                'description' => "This transaction is a test transaction ",
                'activity' => 'REFERRAL_BONUS',
                'reference' => "RF_".rand(1000, 10000),
                'type' => 'Credit',
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Completed",
            ],
            [
                'user_id' => $user->id,
                'currency_id' => 3,
                'fees' => rand(1000, 10000),
                'amount' => rand(1000, 10000),
                'description' => "This transaction is a test transaction ",
                'activity' => 'REFERRAL_BONUS',
                'reference' => "RF_".rand(1000, 10000),
                'type' => 'Credit',
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Completed",
            ],
            [
                'user_id' => $user->id,
                'currency_id' => 3,
                'fees' => rand(1000, 10000),
                'amount' => rand(1000, 10000),
                'description' => "This transaction is a test transaction ",
                'activity' => 'REFERRAL_BONUS',
                'reference' => "RF_".rand(1000, 10000),
                'type' => 'Credit',
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Completed",
            ],
            [
                'user_id' => $user->id,
                'currency_id' => 3,
                'fees' => rand(1000, 10000),
                'amount' => rand(1000, 10000),
                'description' => "This transaction is a test transaction ",
                'activity' => 'REFERRAL_BONUS',
                'reference' => "RF_".rand(1000, 10000),
                'type' => 'Credit',
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Completed",
            ],
            [
                'user_id' => $user->id,
                'currency_id' => 3,
                'fees' => rand(1000, 10000),
                'amount' => rand(1000, 10000),
                'description' => "This transaction is a test transaction ",
                'activity' => 'REFERRAL_BONUS',
                'reference' => "RF_".rand(1000, 10000),
                'type' => 'Credit',
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Completed",
            ],
            [
                'user_id' => $user->id,
                'currency_id' => 3,
                'fees' => rand(1000, 10000),
                'amount' => rand(1000, 10000),
                'description' => "This transaction is a test transaction ",
                'activity' => 'REFERRAL_BONUS',
                'reference' => "RF_".rand(1000, 10000),
                'type' => 'Credit',
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Completed",
            ],
            [
                'user_id' => $user->id,
                'currency_id' => 3,
                'fees' => rand(1000, 10000),
                'amount' => rand(1000, 10000),
                'description' => "This transaction is a test transaction ",
                'activity' => 'REFERRAL_BONUS',
                'reference' => "RF_".rand(1000, 10000),
                'type' => 'Credit',
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Completed",
            ],
        ];


        foreach ($transactions as $key => $transaction) {
            UserTransaction::create($transaction);
        }
    }
}
