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

        DB::table('users')->insert([
            'facebook_id' => '10200830413918894',
            'facebook_token' => 'CAAVrjeXadj4BADZC30MZAxTO0gniKqZAPwjkB8IMyc5AWBr15FQHdquYxn4ZBDQHfsw2IZBRsYxVnvu50bBh30kg2q2bPf1CuZCpqVOZCaR0KAvUAD5CPumeZC4hg4NKKVRFvwwPdYqgcheFFSwH9CZCzIVdXb5mBLoYynOEuFRECU0pcypKRuCSHkGVwCXYTcWKoZCL9QRp0zbrqKLO0fkvf2YPjZB7BmKTC0ZD',
            'name' => 'เชอ โมริ',
            'picurl' => 'https://scontent-kul1-1.xx.fbcdn.net/hphotos-xlp1/v/t1.0-9/1520727_1476771742600564_7339398714263849068_n.jpg?oh=43a9380eabac24dc2a0392086465a58f&oe=573FB65D',
        ]);


        DB::table('users')->insert([
            'facebook_id' => '10200830413918895',
            'facebook_token' => 'CAAVrjeXadj4BADZC30MZAxTO0gniKqZAPwjkB8IMyc5AWBr15FQHdquYxn4ZBDQHfsw2IZBRsYxVnvu50bBh30kg2q2bPf1CuZCpqVOZCaR0KAvUAD5CPumeZC4hg4NKKVRFvwwPdYqgcheFFSwH9CZCzIVdXb5mBLoYynOEuFRECU0pcypKRuCSHkGVwCXYTcWKoZCL9QRp0zbrqKLO0fkvf2YPjZB7BmKTC0ZD',
            'name' => 'Natkritta',
            'picurl' => 'https://scontent-kul1-1.xx.fbcdn.net/hphotos-frc3/v/t1.0-9/10624734_1508305642780507_3281868783704147361_n.jpg?oh=6f2d2ea84ae5f7282357679112c343b6&oe=5726536D',
        ]);
    }
}
