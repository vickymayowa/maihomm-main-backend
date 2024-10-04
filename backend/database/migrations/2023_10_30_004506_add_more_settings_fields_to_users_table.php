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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'hide_balance')) {
                $table->boolean("hide_balance")->default(true);
            }
            if (!Schema::hasColumn('users', 'receive_email_notifications')) {
                $table->boolean("receive_email_notifications")->default(true);
            }
            if (!Schema::hasColumn('users', 'receive_text_notifications')) {
                $table->boolean("receive_text_notifications")->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
