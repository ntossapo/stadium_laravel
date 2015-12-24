<?php

use Illuminate\Database\Seeder;

class StadiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stadiums')->insert([
            'name' => 'TX sport',
            'rating' => 0.0,
            'image' => 'http://static.sportskeeda.com/wp-content/uploads/2014/03/old-trafford-2150165.jpg',
            'describe' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'tel'=> '0950764133',
            'link' => 'www.google.com',
            'time_open' => '09:00',
            'time_close' => '02:00',
            'latitude'=> 0.0,
            'longitude'=> 0.0,
        ]);


        DB::table('stadiums')->insert([
            'name' => 'Phuket Sport Complex',
            'rating' => 0.0,
            'image'=>'http://webhost.phuket.psu.ac.th/itid/stadium/booked/Web/uploads/images/resource9.jpg',
            'describe' => 'Morbi id lorem scelerisque, vulputate mauris sed, sollicitudin dui.',
            'tel'=> '0950764133',
            'link' => 'www.google.com',
            'time_open' => '09:00',
            'time_close' => '02:00',
            'latitude'=> 0.0,
            'longitude'=> 0.0,
        ]);
    }
}
