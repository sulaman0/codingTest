<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserAccountDebitTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'user_account_debit',
            function (Blueprint $blueprint) {
                $blueprint->index('user_id');
                $blueprint->foreign('user_id')->references('id')->on('users');

                $blueprint->index('credit_id');
                $blueprint->foreign('credit_id')->references('id')->on('user_account_credit');

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

        Schema::table(
            'user_account_debit',
            function (Blueprint $blueprint) {
                $blueprint->dropForeign('user_id_foreign');
                $blueprint->dropIndex('user_id_index');
                $blueprint->dropColumn('user_id');


                $blueprint->dropForeign('credit_id_foreign');
                $blueprint->dropIndex('credit_id_index');
                $blueprint->dropColumn('credit_id');
            }
        );
    }
}
