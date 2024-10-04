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
        Schema::table('carts', function (Blueprint $table) {
            if (Schema::hasColumn("carts", "price")) {
                $table->double("price")->default(0)->change();
                $table->double("discount")->default(0)->change();
                $table->double("total")->default(0)->change();
            }
        });
        Schema::table('cart_items', function (Blueprint $table) {
            if (Schema::hasColumn("cart_items", "price")) {
                $table->double("price")->default(0)->change();
                $table->double("total")->default(0)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
