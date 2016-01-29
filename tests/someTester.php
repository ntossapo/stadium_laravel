<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class someTester extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRequestHelloTDDAssertResponseOk(){
        $response = $this->get("/HelloTDD");
        $response->assertResponseOk();
    }

    public function testRequestHelloTDDAssertResponseHello(){
        $response = $this->get("/HelloTDD");
        $response->seeJson(["status"=>"ok"]);
    }
}
