<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CurrencyRateSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'dollar_rate' => 100,
                'pkr_rate'    => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ]
        );

    }
}
