<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 0; $x < 10; $x++) {
            DB::table('users')->insert(
                [
                    'user_name'       => Str::random(10),
                    'user_email'      => Str::random(10).'@gmail.com',
                    'current_balance' => 100,
                    'locked_balance'  => 10,
                    'currency'        => 'usd',
                    'created_at'      => Carbon::now(),
                    'updated_at'      => Carbon::now(),
                ]
            );
        }
    }
}
