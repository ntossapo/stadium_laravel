<?php

use Illuminate\Database\Seeder;
use App\Reserve;
class reserveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reserves')->insert([
            'facebook_id' => '10200830413918893',
            'field_id' => 1,
            'date' => '2559-01-10',
            'time_from' => '10:00:00',
            'time_to'=> '11:00:00',
            'isConfirm' => 0,
        ]);

        DB::table('reserves')->insert([
            'facebook_id' => '10200830413918893',
            'field_id' => 2,
            'date' => '2559-01-10',
            'time_from' => '10:30:00',
            'time_to'=> '11:30:00',
            'isConfirm' => 0,
        ]);
    }
}
