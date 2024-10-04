<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CityTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(UserTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(LanguageTableSeeder::class);
        $this->call(PropertyCategoryTableSeeder::class);
        $this->call(PropertyTableSeeder::class);
        $this->call(PropertyFileTableSeeder::class);
        $this->call(PropertySpecificationTableSeeder::class);
        $this->call(PropertyExcelFileTableSeeder::class);
        // $this->call(InvestmentTableSeeder::class);
        // $this->call(LoanTableSeeder::class);
        // $this->call(TransactionTableSeeder::class);
        // $this->call(NotificationTableSeeder::class);
        
    }
}
