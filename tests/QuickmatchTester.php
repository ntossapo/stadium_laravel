<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QuickmatchTester extends TestCase
{

    public function testRequestSearchQuickMatchAssertResponseOk(){
        $res = $this->post("/quickmatch", ["lat"=>"7.915727", "long"=>"98.367968", "type"=>"soccer"]);
        $res->assertResponseOk();
    }

    public function testRequestSearchQuickMatchAssertResponseJsonStatusOk(){
        $res = $this->post("/quickmatch", ["lat"=>"7.915727", "long"=>"98.367968", "type"=>"soccer"]);
        $res->seeJson(["status"=>"ok"]);
    }
}
