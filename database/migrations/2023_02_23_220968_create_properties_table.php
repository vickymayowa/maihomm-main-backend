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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId("created_by")->constrained("users");
            $table->foreignId("category_id")->nullable()->constrained("property_categories");
            $table->foreignId("currency_id")->constrained("currencies");
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('uuid' , 50)->unique();
            $table->double("price");
            $table->unsignedBigInteger("total_views")->default(0);
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string("sqft")->nullable();
            $table->string("bedrooms")->nullable();
            $table->string("bathrooms")->nullable();
            $table->text("landmark")->nullable();
            $table->text("address")->nullable();
            $table->double("avg_ratings")->default(0);
            $table->integer("total_reviews")->default(0);
            $table->integer("total_clicks")->default(0);
            $table->integer("total_sold")->default(0);
            $table->integer("total_slots")->default(0);
            $table->date('closing_date')->nullable();
            $table->string("status");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
