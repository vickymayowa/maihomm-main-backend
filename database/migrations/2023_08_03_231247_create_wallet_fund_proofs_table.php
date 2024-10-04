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
        Schema::create('wallet_fund_proofs', function (Blueprint $table) {
            $table->id();
            $table->foreignId("wallet_id")->constrained("wallets");
            $table->foreignId("file_id")->constrained("files");
            $table->foreignId("uploaded_by")->constrained("users");
            $table->double("amount");
            $table->string("status")->default(StatusConstants::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_fund_proofs');
    }
};
