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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("property_id")->constrained("properties");
            $table->foreignId("portfolio_id")->nullable()->constrained("portfolios");
            $table->foreignId("payment_id")->nullable()->constrained("payments");
            $table->string("description")->nullable();
            $table->double("value")->nullable();
            $table->integer('term_in_month')->nullable();
            $table->integer("rate")->nullable();
            $table->double('investment_cost');
            $table->integer('slots');
            $table->double('roi')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('maturity_date')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
