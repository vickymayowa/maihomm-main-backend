<?php

use App\Constants\CurrencyConstants;
use App\Helpers\Constants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable("currencies")) {
            Schema::create('currencies', function (Blueprint $table) {
                $table->id();
                $table->string("name");
                $table->string("type", 50)->unique();
                $table->double("price_per_dollar");
                $table->string("short_name", 20)->unique();
                $table->string("logo")->nullable();
                $table->string("status");
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
        Schema::dropIfExists('currencies');
    }
}
