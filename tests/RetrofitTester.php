<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RetrofitTest extends TestCase
{
    public function testRequetGetRetrofitAssertResponseHello_(){
        $res = $this->get("/retrofit");
        $res->see("Hello");
    }
}
