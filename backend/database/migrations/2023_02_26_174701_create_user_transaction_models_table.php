<?php

use App\Constants\TransactionConstants;
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
        Schema::create('user_transaction_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("currency_id")->constrained("currencies");
            $table->double("fees")->default(0);
            $table->double("amount")->default(0);
            $table->string("description")->nullable();
            $table->string("activity")->nullable();
            $table->string("batch_no")->nullable();
            $table->string("reference", 20)->unique();
            $table->enum("type", [
                TransactionConstants::CREDIT,
                TransactionConstants::DEBIT
            ]);
            $table->string("status");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_transaction_models');
    }
};
