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
        Schema::table('cart_items', function (Blueprint $table) {
            if (!Schema::hasColumn("cart_items", "fees")) {
                $table->decimal("fees")->after("quantity")->default(0);
            }
            if (!Schema::hasColumn("cart_items", "taxes")) {
                $table->decimal("taxes")->after("fees")->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            //
        });
    }
};
