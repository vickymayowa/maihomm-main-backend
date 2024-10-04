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
        Schema::table('amenities', function (Blueprint $table) {
            if (Schema::hasColumn("amenities", "icon")) {
                $table->dropColumn("icon");
            }
            if (!Schema::hasColumn("amenities", "icon_id")) {
                $table->foreignId("icon_id")->nullable()->after("name")->constrained("files");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amenities', function (Blueprint $table) {
            //
        });
    }
};
