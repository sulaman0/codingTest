<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserAccountCreditTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'user_account_credit',
            function (Blueprint $blueprint) {
                $blueprint->index('user_id');
                $blueprint->foreign('user_id')->references('id')->on('users');

                $blueprint->index('debit_id');
                $blueprint->foreign('debit_id')->references('id')->on('user_account_debit');
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


                $blueprint->dropForeign('debit_id_foreign');
                $blueprint->dropIndex('debit_id_index');
                $blueprint->dropColumn('debit_id');
            }
        );

    }
}
