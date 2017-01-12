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
            'link' => 'http://www.txparkphuket.com/',
            'time_open' => '09:00',
            'time_close' => '02:00',
            'latitude'=> 7.905612,
            'longitude'=> 98.384058,
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
            'latitude'=> 7.895174,
            'longitude'=> 98.354034,
        ]);

        DB::table('stadiums')->insert([
            'name' => 'โรงแบดภูเก็จ',
            'rating' => 0.0,
            'image'=>'https://irs0.4sqi.net/img/general/width960/8655673_cHjgmb4X2XH8hPPnX2Q88RT-8bjdB0t5jzguLhnGblk.jpg',
            'describe' => 'สนามแบดมินตัน 7 สนาม พื้นยาง PVC มาตรฐานการแข่งขันระดับนานาชาติ หนา 6 มม. (Opens Everyday 9am - Midnight)',
            'tel'=> '076 217 172',
            'link' => 'https://th.foursquare.com/v/%E0%B9%82%E0%B8%A3%E0%B8%87%E0%B9%81%E0%B8%9A%E0%B8%94%E0%B8%A0%E0%B9%80%E0%B8%81%E0%B8%88-phuket-badminton-hall/50ec1789e4b0d785b9fcb606',
            'time_open' => '09:00',
            'time_close' => '00:00',
            'latitude'=> 7.865908,
            'longitude'=> 98.372055,
        ]);

        DB::table('stadiums')->insert([
            'name' => 'Surakun Stadium',
            'rating' => 0.0,
            'image'=>'https://irs0.4sqi.net/img/general/width960/8655673_cHjgmb4X2XH8hPPnX2Q88RT-8bjdB0t5jzguLhnGblk.jpg',
            'describe' => '',
            'tel'=> '061 704 8370',
            'link' => 'https://lh6.googleusercontent.com/proxy/tDK3A2RQW6cTIJEC6Bd5uOU5vqH24CcF5VSuu7ZwPwmsdifxdQWl2td9GTKOMcSo57WlVt-uJjh4IWIUABmVcfm3tWWJm6vrYaOR7WrybeC1=s0-d',
            'time_open' => '09:00',
            'time_close' => '00:00',
            'latitude'=> 7.88798,
            'longitude'=> 98.3661967,
        ]);

        DB::table('stadiums')->insert([
            'name' => 'Patong Football Club',
            'rating' => 0.0,
            'image'=>'https://scontent.fbkk14-1.fna.fbcdn.net/v/t1.0-9/11201624_814188035317308_6877114664862139600_n.jpg?oh=da59e130a6fa4548c97972cc12dd9d45&oe=591F749A',
            'describe' => 'สนามฟุตบอลหญ้าเทียม แห่งแรกในป่าตอง',
            'tel'=> '090 065 9422',
            'link' => 'http://www.patongfc.com/',
            'time_open' => '00:00',
            'time_close' => '00:00',
            'latitude'=> 7.882655,
            'longitude'=> 98.2968289,
        ]);
    }
}
