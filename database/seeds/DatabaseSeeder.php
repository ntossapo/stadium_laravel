<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(reserveSeeder::class);
        $this->call(FieldSeeder::class);
        $this->call(StadiaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(JoinSeeder::class);
        Model::reguard();
    }
}
