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
        Schema::create('payment_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId("payment_id")->constrained("payments");
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("file_id")->constrained("files");
            $table->string("status")->default(StatusConstants::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_files');
    }
};
