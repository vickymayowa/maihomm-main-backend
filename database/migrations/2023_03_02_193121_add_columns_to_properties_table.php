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
            if (!Schema::hasColumns("properties", ["first_year_projection", "fifth_year_projection", "tenth_year_projection"])) {
                $table->double("maihomm_fee")->after("price")->nullable();
                $table->double("first_year_projection")->after("address")->nullable();
                $table->double("fifth_year_projection")->after("first_year_projection")->nullable();
                $table->double("tenth_year_projection")->after("fifth_year_projection")->nullable();
                $table->double("legal_and_closing_cost")->after("tenth_year_projection")->nullable();
                $table->double("per_slot")->after("legal_and_closing_cost")->nullable();
                $table->double("property_acq_cost")->after("per_slot")->nullable();
                $table->double("service_charge")->after("property_acq_cost")->nullable();
                $table->double("management_fees")->after("service_charge")->nullable();
                $table->double("projected_gross_rent")->after("management_fees")->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumns("properties", ["first_year_projection", "fifth_year_projection", "tenth_year_projection"])) {
                $table->dropColumn("fee");
                $table->dropColumn("first_year_projection");
                $table->dropColumn("fifth_year_projection");
                $table->dropColumn("tenth_year_projection");
                $table->dropColumn("legal_and_closing_cost");
                $table->dropColumn("per_slot");
                $table->dropColumn("property_acq_cost");
                $table->dropColumn("service_charge");
                $table->dropColumn("management_fees");
                $table->dropColumn("projected_gross_rent");
            }
        });
    }
};
