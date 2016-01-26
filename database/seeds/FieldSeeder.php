<?php

use Illuminate\Database\Seeder;
class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields')->insert([
            'name' => 'Soccer 1',
            'stadium_id' => 1,
            'type' => 'soccer'
        ]);

        DB::table('fields')->insert([
            'name' => 'Soccer 2',
            'stadium_id' => 1,
            'type' => 'soccer'
        ]);

        DB::table('fields')->insert([
            'name' => 'Soccer 3',
            'stadium_id' => 1,
            'type' => 'soccer'
        ]);

        DB::table('fields')->insert([
            'name' => 'Soccer',
            'stadium_id' => 2,
            'type' => 'soccer'
        ]);

        DB::table('fields')->insert([
            'name' => 'Badminton 1',
            'stadium_id' => 2,
            'type' => 'badminton'
        ]);

        DB::table('fields')->insert([
            'name' => 'Badminton 2',
            'stadium_id' => 2,
            'type' => 'badminton'
        ]);

        DB::table('fields')->insert([
            'name' => 'Soccer 1',
            'stadium_id' => 3,
            'type' => 'soccer'
        ]);

        DB::table('fields')->insert([
            'name' => 'Soccer 2',
            'stadium_id' => 3,
            'type' => 'soccer'
        ]);
    }
}
