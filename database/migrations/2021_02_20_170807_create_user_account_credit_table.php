<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAccountCreditTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'user_account_credit',
            function (Blueprint $table) {
                $table->increments('id');

                $table->integer('user_id')->unsigned();
                $table->integer('debit_id')->nullable()->unsigned();

                $table->enum('currency', ['usd', 'pkr']);
                $table->unsignedDecimal('transfer_amount', 8, 3);

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
        Schema::dropIfExists('user_account_credit');
    }
}
