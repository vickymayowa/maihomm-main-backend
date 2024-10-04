<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumns("properties", ["sqft"])) {
                $table->dropColumn("sqft");
            }
        });

        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumns("properties", ["area_sq_ft"])) {
                $table->dropColumn("area_sq_ft");
            }
        });

        Schema::table('properties', function (Blueprint $table) {
            if (!Schema::hasColumn("properties", "sqft")) {
                $table->string("sqft")->nullable()->after("per_slot");
            }
        });


        // Schema::table('properties', function (Blueprint $table) {
        //     if (Schema::hasColumns("properties", ["area_sq_ft"])) {
        //         try {
        //             $table->renameColumn("area_sq_ft", "sqft");
        //         } catch (\Throwable $th) {
        //             DB::statement("ALTER TABLE properties CHANGE COLUMN area_sq_ft sqft double;");
        //         }
        //     }
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
