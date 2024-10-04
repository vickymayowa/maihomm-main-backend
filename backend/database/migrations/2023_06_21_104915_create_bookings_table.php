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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("property_id")->constrained("properties");
            // $table->foreignId("habitable_day_id")->constrained("habitable_days");
            $table->string("reference")->unique();
            $table->integer("slots")->default(1);
            $table->string("check_in")->nullable();
            $table->string("check_out")->nullable();
            $table->integer("number_of_guests")->default(1);
            $table->double("total_price")->default(1);
            // $table->integer("habitable_days")->default(1);
            // $table->integer("habitable_days_usage")->nullable();
            $table->double("service_fee")->default(0.00);
            $table->string("status")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
