<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Reserve;
class reserveTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testRequestAssertResponseOk(){
        $res = $this->post("/reserve", ['user'=>'10200830413918893', 'time_to'=>'10.00', 'time_from'=>'12.00', 'date' => date('YYYY-mm-dd'), 'field'=>1]);
        $res->assertResponseOk();
        Reserve::truncate();
    }

    public function testRequestValidFormAssertResponseStatusOk(){
        $res = $this->post("/reserve", ['user'=>'10200830413918893', 'time_to'=>'10.00', 'time_from'=>'12.00', 'date' => date('YYYY-mm-dd'), 'field'=>1]);
        $res->seeJsonContains(['status'=>'ok']);
        Reserve::truncate();
    }

    public function testRequestValidFormAssertDataInDatabase(){
        $res = $this->post("/reserve", ['user'=>"10200830413918893", 'time_to'=>'10.00', 'time_from'=>'12.00', 'date' => date('YYYY-mm-dd'), 'field'=>1]);
        $reserve = Reserve::all()->first();
        $this->assertEquals($reserve->facebook_id, '10200830413918893');
        Reserve::truncate();
    }

    public function testRequestInvalidUserFormAssertResponseErr(){
        $res = $this->post("/reserve", ['user'=>"10200830413918892", 'time_to'=>'10.00', 'time_from'=>'12.00', 'date' => date('YYYY-mm-dd'), 'field'=>1]);
        $res->seeJsonContains(['status'=>'err']);
        Reserve::truncate();
    }


}
