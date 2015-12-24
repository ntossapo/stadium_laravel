<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Field;
class testGetAllReserve extends TestCase
{

   public function testRequestGetAssertResponseOk(){
       $res = $this->get("/all/10200830413918893/soccer/");
       $res->assertResponseOk();
   }

    public function testRequestGetAssertResponseJsonContainStatusOk(){
        $res = $this->get("/all/10200830413918893/soccer/");

        $res->seeJsonContains(["status"=>"ok"]);
    }

    public function testRequestGetAssertResponseStatusNotOkBecauseUserInvalid(){
        $res = $this->get("/all/10200830413918890/soccer/");
        $res->seeJsonContains(["status"=>"err", "err"=>"User Invalid"]);
    }

    public function testRequestGetAssertResponseJsonDataAsMyPattern(){
        $res = $this->get("/all/10200830413918893/soccer/");
        $res->seeJsonContains(["status"=>"ok"]);
    }
}
