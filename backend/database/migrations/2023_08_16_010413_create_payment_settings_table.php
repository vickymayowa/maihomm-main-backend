<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->double("min_deposit")->default(0);
            $table->double("max_deposit")->default(0);
            $table->double("min_withdrawal")->default(0);
            $table->double("max_withdrawal")->default(0);
            $table->boolean("allow_naira")->default(false);
            $table->boolean("allow_pound")->default(false);
            $table->boolean("allow_dollar")->default(false);
            $table->boolean("is_cash")->default(false);
            $table->boolean("is_paystack")->default(false);
            $table->boolean("is_flutterwave")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
