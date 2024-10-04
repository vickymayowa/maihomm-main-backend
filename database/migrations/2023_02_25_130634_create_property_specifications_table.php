<?php

use App\Constants\StatusConstants;
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
        Schema::create('property_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId("property_id")->constrained("properties");
            $table->string("title");
            $table->string("key");
            $table->string("value");
            $table->double("price")->nullable();
            $table->tinyInteger("is_default")->nullable();
            $table->string("group")->nullable();
            $table->text("metadata")->nullable();
            $table->string("status")->default(StatusConstants::ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_specifications');
    }
};
