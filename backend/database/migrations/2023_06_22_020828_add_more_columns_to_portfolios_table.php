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
        Schema::table('portfolios', function (Blueprint $table) {
            if (!Schema::hasColumn("portfolios", "investment_value")) {
                $table->double("investment_value")->nullable()->default(0)->after("value_appreciation");
                $table->double("current_value")->nullable()->default(0)->after("investment_value");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn("investment_value");
            $table->dropColumn("current_value");
        });
    }
};
