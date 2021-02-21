<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyRateTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'currency_rate',
            function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedDecimal('dollar_rate', 8, 3);
                $table->unsignedDecimal('pkr_rate', 8, 3);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_rate');
    }
}
