<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Payment;
use App\Models\Property;
use Illuminate\Database\Seeder;
use App\Services\Portfolio\PortfolioService;
use App\Services\Investment\InvestmentService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InvestmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(72);
        $portfolio = PortfolioService::create([
            "user_id" => !empty($user) ? $user->id : User::inRandomOrder()->first()->id,
            "monthly_income" => 20000,
            "total_income" => 300000,
            "value_appreciation" => 2000,
        ]);

        $payment = Payment::inRandomOrder()->first();
        $property = Property::inRandomOrder()->first();

        $investments = [
            [
                'portfolio_id' => $portfolio->id,
                'property_id' => $property->id,
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'slots' => 3,
                'description' => "This investment is a test investment ",
                'value' => rand(100, 10000),
                'term_in_month' => rand(1, 100),
                'rate' => rand(10, 20),
                'roi' => rand(10, 20),
                'investment_cost' => rand(100, 10000),
                'value' => rand(1000, 10000),
                'status' => "Active",
                'start_date' => now(),
                'maturity_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'portfolio_id' => $portfolio->id,
                'property_id' => $property->id,
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'slots' => 3,
                'description' => "This investment is a test investment ",
                'value' => rand(100, 10000),
                'term_in_month' => rand(1, 100),
                'rate' => rand(10, 20),
                'roi' => rand(10, 20),
                'investment_cost' => rand(100, 10000),
                'value' => rand(1000, 10000),
                'status' => "Active",
                'start_date' => now(),
                'maturity_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'portfolio_id' => $portfolio->id,
                'property_id' => $property->id,
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'slots' => 3,
                'description' => "This investment is a test investment ",
                'value' => rand(100, 10000),
                'term_in_month' => rand(1, 100),
                'rate' => rand(10, 20),
                'roi' => rand(10, 20),
                'investment_cost' => rand(100, 10000),
                'value' => rand(1000, 10000),
                'status' => "Active",
                'start_date' => now(),
                'maturity_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'portfolio_id' => $portfolio->id,
                'property_id' => $property->id,
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'slots' => 3,
                'description' => "This investment is a test investment ",
                'value' => rand(100, 10000),
                'term_in_month' => rand(1, 100),
                'rate' => rand(10, 20),
                'roi' => rand(10, 20),
                'investment_cost' => rand(100, 10000),
                'value' => rand(1000, 10000),
                'status' => "Active",
                'start_date' => now(),
                'maturity_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'portfolio_id' => $portfolio->id,
                'property_id' => $property->id,
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'slots' => 3,
                'description' => "This investment is a test investment ",
                'value' => rand(100, 10000),
                'term_in_month' => rand(1, 100),
                'rate' => rand(10, 20),
                'roi' => rand(10, 20),
                'investment_cost' => rand(100, 10000),
                'value' => rand(1000, 10000),
                'status' => "Active",
                'start_date' => now(),
                'maturity_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'portfolio_id' => $portfolio->id,
                'property_id' => $property->id,
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'slots' => 3,
                'description' => "This investment is a test investment ",
                'value' => rand(100, 10000),
                'term_in_month' => rand(1, 100),
                'rate' => rand(10, 20),
                'roi' => rand(10, 20),
                'investment_cost' => rand(100, 10000),
                'value' => rand(1000, 10000),
                'status' => "Active",
                'start_date' => now(),
                'maturity_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'portfolio_id' => $portfolio->id,
                'property_id' => $property->id,
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'slots' => 3,
                'description' => "This investment is a test investment ",
                'value' => rand(100, 10000),
                'term_in_month' => rand(1, 100),
                'rate' => rand(10, 20),
                'roi' => rand(10, 20),
                'investment_cost' => rand(100, 10000),
                'value' => rand(1000, 10000),
                'status' => "Active",
                'start_date' => now(),
                'maturity_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'portfolio_id' => $portfolio->id,
                'property_id' => $property->id,
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'slots' => 3,
                'description' => "This investment is a test investment ",
                'value' => rand(100, 10000),
                'term_in_month' => rand(1, 100),
                'rate' => rand(10, 20),
                'roi' => rand(10, 20),
                'investment_cost' => rand(100, 10000),
                'value' => rand(1000, 10000),
                'status' => "Active",
                'start_date' => now(),
                'maturity_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'portfolio_id' => $portfolio->id,
                'property_id' => $property->id,
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'slots' => 3,
                'description' => "This investment is a test investment ",
                'value' => rand(100, 10000),
                'term_in_month' => rand(1, 100),
                'rate' => rand(10, 20),
                'roi' => rand(10, 20),
                'investment_cost' => rand(100, 10000),
                'value' => rand(1000, 10000),
                'status' => "Active",
                'start_date' => now(),
                'maturity_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'portfolio_id' => $portfolio->id,
                'property_id' => $property->id,
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'slots' => 3,
                'description' => "This investment is a test investment ",
                'value' => rand(100, 10000),
                'term_in_month' => rand(1, 100),
                'rate' => rand(10, 20),
                'roi' => rand(10, 20),
                'investment_cost' => rand(100, 10000),
                'status' => "Active",
                'start_date' => now(),
                'maturity_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($investments as $key => $investment) {
            (new InvestmentService)->save($investment);
        }
    }
}
