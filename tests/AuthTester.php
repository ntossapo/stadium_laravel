<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
class AuthTester extends TestCase
{
    public function testRequestFormAssertResponseOk(){
        $res = $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.google.com"]);
        $res->assertResponseOk();
        User::truncate();
    }

    public function testRequestFormAssertReponseJson(){
        $res = $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.google.com"]);
        $res->seeJsonContains(["status"=>"ok"]);
        User::truncate();
    }

    public function testRequestFormAssertFormInDB(){
        $res = $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.google.com"]);
        $count = User::all()->count();
        $this->assertEquals(1, $count);
        User::truncate();
    }

    public function testRequestDoubleFormAssertOneInDatabase(){
        $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.google.com"]);
        $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.google.com"]);
        $count = User::all()->count();
        $this->assertEquals(1, $count);
        User::truncate();
    }

    public function testRequestToChangeTokenAssertTokenHasChange(){
        $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.google.com"]);
        $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"987ewq654dsa321cxz987ewq654dsa321cxz", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.google.com"]);
        $user = User::where("facebook_id", "=", "123456789")->first();
        $this->assertEquals("987ewq654dsa321cxz987ewq654dsa321cxz", $user->facebook_token);
        User::truncate();
    }

    public function testRequestChangeNameAssertNameHasChange(){
        $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.google.com"]);
        $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Jasmine", "picurl"=>"http://www.google.com"]);
        $user = User::where("facebook_id", "=", "123456789")->first();
        $this->assertEquals("Jasmine", $user->name);
        User::truncate();
    }

    public function testRequestChangeUrlPicAssertUrlPicHasChange(){
        $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.google.com"]);
        $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.zxcasdqwe.com"]);
        $user = User::where("facebook_id", "=", "123456789")->first();
        $this->assertEquals("http://www.zxcasdqwe.com", $user->picurl);
        User::truncate();
    }

    public function testRequestChangeNameAndUrlPicAssertNameAndUrlPicHasChange(){
        $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.google.com"]);
        $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Jasmine", "picurl"=>"http://www.miniclip.com"]);
        $user = User::where("facebook_id", "=", "123456789")->first();
        $this->assertEquals("Jasmine", $user->name);
        $this->assertEquals("http://www.miniclip.com", $user->picurl);
        User::truncate();
    }

    public function testRequestToAuthResponseStatusOkAndData(){
        $res = $this->post("/auth", ["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.google.com"]);
        $res->seeJsonContains(["facebook_id"=>"123456789", "facebook_token"=>"123zxc456asd789qwe123zxc456asd789qwe", "name"=>"Tossapon Nuanchuay", "picurl"=>"http://www.google.com"]);
        User::truncate();
    }
}
