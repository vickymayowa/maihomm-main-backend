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
        Schema::create('property_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId("property_id")->constrained("properties");
            $table->foreignId("file_id")->constrained("files");
            $table->string("type");
            $table->tinyInteger("order")->nullable();
            $table->tinyInteger("is_default")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_files');
    }
};
