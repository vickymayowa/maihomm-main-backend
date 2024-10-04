<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddNationalityToKycVerificationsTable extends Migration
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
            Schema::create('new_kyc_verifications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('id_type');
                // $table->string('nin')->nullable();
                $table->string('nationality'); // Add the new field
                $table->timestamps();

                // Define foreign key constraints
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });

            // Copy data from old table to new table
            DB::statement('INSERT INTO new_kyc_verifications SELECT id, user_id, id_type, "" as nationality, created_at, updated_at FROM kyc_verifications');

            // Drop the old table
            Schema::drop('kyc_verifications');

            // Rename the new table to the old table name
            Schema::rename('new_kyc_verifications', 'kyc_verifications');
        } else {
            Schema::table('kyc_verifications', function (Blueprint $table) {
                $table->string('nationality')->after('id_type')->nullable();
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
            // Create a new table without the nationality column
            Schema::create('new_kyc_verifications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('id_type');
                // $table->string('nin')->nullable();
                $table->timestamps();

                // Define foreign key constraints
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });

            // Copy data from old table to new table
            DB::statement('INSERT INTO new_kyc_verifications SELECT id, user_id, id_type, created_at, updated_at FROM kyc_verifications');

            // Drop the old table
            Schema::drop('kyc_verifications');

            // Rename the new table to the old table name
            Schema::rename('new_kyc_verifications', 'kyc_verifications');
        } else {
            Schema::table('kyc_verifications', function (Blueprint $table) {
                $table->dropColumn('nationality');
            });
        }
    }
}
