<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Reserve;

class myReserveTester extends TestCase
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

    public function testRequestMyReserveAssertResponseOk(){
        $res = $this->post("/myreserve", ["facebookId" => "10200830413918893"]);
        $res->assertResponseOk();
    }

    public function testRequestMyReserveAssertResponseStatusOK(){
        $res = $this->post("/myreserve", ["facebookId" => "10200830413918893"]);
        $res->seeJson(["status"=>"ok"]);
    }

    public function testRequestMyReserveAssertResponseJsonData(){
        $res = $this->post("/myreserve", ["facebookId" => "10200830413918893"]);
        $res->seeJson(["status"=>"ok"]);
    }

    public function testRequestMyReserveAssertResponseJsonStatusErr(){
        $res = $this->post("/myreserve", ["facebookId" => "10200830413918894"]);
        $res->seeJson(["status"=>"err"]);
    }
}
