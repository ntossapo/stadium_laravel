<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuickController extends Controller
{
    public function getQuickMatch(){
        $lat = Input::get("lat");
        $long = Input::get("long");
        $type = Input::get("type");
        $user = Input::get("facebookId");

        $data = DB::select('
            SELECT RESERVES.*, STADIUMS.NAME, STADIUMS.LATITUDE, STADIUMS.LONGITUDE, FIELDS.NAME
            FROM RESERVES, STADIUMS, FIELDS, JOINS
            WHERE
              RESERVES.FACEBOOK_ID != :facebook AND
              RESERVES.FIELD_ID = FIELDS.ID AND
              FIELDS.STADIUM_ID = STADIUMS.ID AND
              FIELDS.TYPE = :type AND
              RESERVES.DATE >= CURDATE() AND
              RESERVES.TIME_FROM >= curtime() AND
              JOINS.RESERVE_ID = RESERVES.ID AND
              JOINS.USER_ID != :facebook2
              ORDER BY SQRT(POW(STADIUMS.LATITUDE - :lat, 2) + POW(STADIUMS.LONGITUDE - :long, 2)) ASC
        ', ["lat"=>$lat, "long"=>$long, "type"=>$type, "facebook"=>$user, "facebook2"=>$user]);

        foreach($data as $val){
            $user = DB::SELECT('
                SELECT USERS.NAME
                FROM USERS, JOINS
                WHERE
                  JOINS.RESERVE_ID = :reserveId AND
                  USERS.FACEBOOK_ID = JOINS.USER_ID
            ', ["reserveId"=> $val->id]);
            $val->user = $user;
        }

        return response()->json(["status"=>"ok", "data"=>$data]);
    }
}
