<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PrereserveTester extends TestCase
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

    public function testRequestPreReserverAssertResponseOk(){
        $res = $this->post("/prereserve", ["stadium"=>"1", "time_to"=>"10.00", "time_from"=>"09.00", "type"=>"soccer"]);
        $res->assertResponseOk();
    }

    public function testRequestPreReserveAssertReponseJson(){
        $res = $this->post("/prereserve", ["stadium"=>"1", "time_to"=>"10.00", "time_from"=>"09.00", "type"=>"soccer"]);
        $res->seeJsonContains(["status"=>"ok"]);
    }


}
