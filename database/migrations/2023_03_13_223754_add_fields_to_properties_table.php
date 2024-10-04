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
        Schema::table('properties', function (Blueprint $table) {
            if (!Schema::hasColumns("properties", ["one_time_payment_per_slot", "rental_cost_per_night"])) {
                $table->double("one_time_payment_per_slot")->after("per_slot")->nullable();
                $table->double("area_sq_ft")->after("one_time_payment_per_slot")->nullable();
                $table->double("projected_annual_yield")->after("area_sq_ft")->nullable();
                $table->double("average_occupancy")->after("projected_annual_yield")->nullable();
                $table->double("rental_cost_per_night")->after("average_occupancy")->nullable();
                $table->double("projected_annual_net_rental_income")->after("rental_cost_per_night")->nullable();
                $table->double("projected_annual_rental_income_per_slot")->after("projected_annual_net_rental_income")->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumns("properties", ["one_time_payment_per_slot", "rental_cost_per_night"])) {
                $table->dropColumn("one_time_payment_per_slot");
                $table->dropColumn("area_sq_ft");
                $table->dropColumn("projected_annual_yield");
                $table->dropColumn("average_occupancy");
                $table->dropColumn("rental_cost_per_night");
                $table->dropColumn("projected_annual_net_rental_income");
                $table->dropColumn("projected_annual_rental_income_per_slot");
            }
        });
    }
};
