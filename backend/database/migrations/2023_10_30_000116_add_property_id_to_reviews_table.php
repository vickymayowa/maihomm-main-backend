<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPropertyIdToReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::getConnection()->getDriverName() == 'sqlite') {
            // Create a new table with the updated schema
            Schema::create('new_reviews', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('property_id');
                // $table->unsignedBigInteger('reviewable_id');
                // $table->string('reviewable_type');
                // $table->text('body');
                $table->timestamps();

                // Define foreign key constraints
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            });

            // Copy data from old table to new table
            DB::statement('INSERT INTO new_reviews SELECT id, user_id, NULL as property_id, created_at, updated_at FROM reviews');

            // Drop the old table
            Schema::drop('reviews');

            // Rename the new table to the old table name
            Schema::rename('new_reviews', 'reviews');
        } else {
            Schema::table('reviews', function (Blueprint $table) {
                $table->unsignedBigInteger('property_id')->after('user_id');
                $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::getConnection()->getDriverName() == 'sqlite') {
            // Create a new table without the property_id column
            Schema::create('new_reviews', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                // $table->unsignedBigInteger('reviewable_id');
                // $table->string('reviewable_type');
                // $table->text('body');
                $table->timestamps();

                // Define foreign key constraints
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });

            // Copy data from old table to new table
            DB::statement('INSERT INTO new_reviews SELECT id, user_id, created_at, updated_at FROM reviews');

            // Drop the old table
            Schema::drop('reviews');

            // Rename the new table to the old table name
            Schema::rename('new_reviews', 'reviews');
        } else {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropForeign(['property_id']);
                $table->dropColumn('property_id');
            });
        }
    }
}

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::table('reviews', function (Blueprint $table) {
//             if (Schema::hasColumn('reviews', 'booking_id')) {
//                 $table->dropConstrainedForeignId("booking_id");
//             }
//             if (!Schema::hasColumn('reviews', 'property_id')) {
//                 $table->foreignId("property_id")->nullable()->after("user_id")->constrained("properties")->cascadeOnDelete();
//             }
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::table('reviews', function (Blueprint $table) {
//             //
//         });
//     }
// };
