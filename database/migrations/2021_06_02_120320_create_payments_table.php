<?php

use App\Constants\StatusConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable("payments")) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId("currency_id")->constrained("currencies");
                $table->string('reference' , 50)->unique();
                $table->double('discount' , 12 , 2)->default(0);
                $table->double('amount' , 12 , 2);
                $table->double('fee' , 12 , 2)->default(0);
                $table->foreignId('user_id')->constrained("users");
                $table->unsignedBigInteger('transaction_id')->nullable();
                $table->string('coupon_code')->nullable();
                $table->string('gateway')->nullable();
                $table->string('activity');
                $table->text("metadata")->nullable();
                $table->dateTime('confirmed_at')->nullable();
                $table->string('status')->default(StatusConstants::PENDING);
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('payments');
    }
}
