<?php

use Illuminate\Database\Seeder;

class JoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('joins')->insert([
           'reserve_id' => '3',
            'user_id' => '10200830413918895'
        ]);
    }
}
