<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'facebook_id' => '10200830413918893',
            'facebook_token' => 'CAAVrjeXadj4BADZC30MZAxTO0gniKqZAPwjkB8IMyc5AWBr15FQHdquYxn4ZBDQHfsw2IZBRsYxVnvu50bBh30kg2q2bPf1CuZCpqVOZCaR0KAvUAD5CPumeZC4hg4NKKVRFvwwPdYqgcheFFSwH9CZCzIVdXb5mBLoYynOEuFRECU0pcypKRuCSHkGVwCXYTcWKoZCL9QRp0zbrqKLO0fkvf2YPjZB7BmKTC0ZD',
            'name' => 'Tossapon Nuanchuay',
            'picurl' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xtp1/v/t1.0-1/p50x50/10415701_10200906091410783_7480276628683382652_n.jpg?oh=5d586b95cd564373cb870521187b4ffa&oe=570CD269&__gda__=1460385957_9462535a4d82d1794509df1956e4a883',
        ]);
    }
}
