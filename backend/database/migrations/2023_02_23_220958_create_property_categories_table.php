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
        Schema::create('property_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId("logo_id")->nullable()->constrained("files");
            $table->string('name' , 100)->unique();
            $table->string('uuid' , 50)->unique();
            $table->unsignedBigInteger("category_id")->nullable();
            $table->unsignedBigInteger("total_properties")->default(0);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_categories');
    }
};
