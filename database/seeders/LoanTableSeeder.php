<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LoanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(72);

        $loans = [
            [
                'user_id' => $user->id,
                'amount' => rand(1000, 10000),
                'eligible_amount' => rand(1000, 10000),
                'reference' => rand(1000, 10000),
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Active",
            ],
            [
                'user_id' => $user->id,
                'amount' => rand(1000, 10000),
                'eligible_amount' => rand(1000, 10000),
                'reference' => rand(1000, 10000),
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Active",
            ],
            [
                'user_id' => $user->id,
                'amount' => rand(1000, 10000),
                'eligible_amount' => rand(1000, 10000),
                'reference' => rand(1000, 10000),
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Active",
            ],
            [
                'user_id' => $user->id,
                'amount' => rand(1000, 10000),
                'eligible_amount' => rand(1000, 10000),
                'reference' => rand(1000, 10000),
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Active",
            ],
            [
                'user_id' => $user->id,
                'amount' => rand(1000, 10000),
                'eligible_amount' => rand(1000, 10000),
                'reference' => rand(1000, 10000),
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Active",
            ],
            [
                'user_id' => $user->id,
                'amount' => rand(1000, 10000),
                'eligible_amount' => rand(1000, 10000),
                'reference' => rand(1000, 10000),
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Active",
            ],
            [
                'user_id' => $user->id,
                'amount' => rand(1000, 10000),
                'eligible_amount' => rand(1000, 10000),
                'reference' => rand(1000, 10000),
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Active",
            ],
            [
                'user_id' => $user->id,
                'amount' => rand(1000, 10000),
                'eligible_amount' => rand(1000, 10000),
                'reference' => rand(1000, 10000),
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Active",
            ],
            [
                'user_id' => $user->id,
                'amount' => rand(1000, 10000),
                'eligible_amount' => rand(1000, 10000),
                'reference' => rand(1000, 10000),
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Active",
            ],
            [
                'user_id' => $user->id,
                'amount' => rand(1000, 10000),
                'eligible_amount' => rand(1000, 10000),
                'reference' => rand(1000, 10000),
                'status' => (rand(0, 1) == 0 ) ? 'Pending' : "Active",
            ],
        ];


        foreach ($loans as $key => $loan) {
            Loan::create($loan);
        }
    }
}
