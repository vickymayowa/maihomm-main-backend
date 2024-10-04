<?php

use App\Constants\TransactionConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
