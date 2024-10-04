<?php

namespace Database\Seeders;

use App\Constants\CurrencyConstants;
use App\Constants\StatusConstants;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                "name" => "Pound",
                "type" => CurrencyConstants::POUND_CURRENCY,
                "price_per_dollar" => 1,
                "short_name" => "£",
                "logo" => null,
                "status" => StatusConstants::ACTIVE,
            ],
            [
                "name" => "Euro",
                "type" => CurrencyConstants::EURO_CURRENCY,
                "price_per_dollar" => 1,
                "short_name" => "€",
                "logo" => null,
                "status" => StatusConstants::ACTIVE,
            ],
            [
                "name" => "Dollar",
                "type" => CurrencyConstants::DOLLAR_CURRENCY,
                "price_per_dollar" => 1,
                "short_name" => "$",
                "logo" => null,
                "status" => StatusConstants::ACTIVE,
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::firstOrCreate(["type" => $currency["type"]], $currency);
        }
    }
}
