<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Input;
use App\Http\Requests;

class QuickController extends Controller
{
    public function getQuickMatch(){
        $lat = Input::get("lat");
        $long = Input::get("long");
        $type = Input::get("type");
        $user = Input::get("facebookId");

        $data = DB::select('
            SELECT RESERVES.*, STADIUMS.NAME, STADIUMS.LATITUDE, STADIUMS.LONGITUDE, FIELDS.NAME
            , (SELECT COUNT(JOINS.FACEBOOK_ID) FROM JOINS WHERE JOINS.FACEBOOK_ID = :facebook2) AS ISJOINED
            FROM RESERVES, STADIUMS, FIELDS
            WHERE
              RESERVES.FACEBOOK_ID != :facebook AND
              RESERVES.FIELD_ID = FIELDS.ID AND
              FIELDS.STADIUM_ID = STADIUMS.ID AND
              FIELDS.TYPE = :type AND
              RESERVES.DATE >= CURDATE()
              ORDER BY SQRT(POW(STADIUMS.LATITUDE - :lat, 2) + POW(STADIUMS.LONGITUDE - :long, 2)) ASC, RESERVES.DATE ASC, RESERVES.TIME_FROM ASC
        ', ["lat"=>$lat, "long"=>$long, "type"=>$type, "facebook"=>$user, "facebook2"=>$user]);

        foreach($data as $key=>$val){
            if($val->ISJOINED == 1) {
                unset($data[$key]);
                continue;
            }
            $users = DB::SELECT('
                SELECT USERS.NAME
                FROM USERS, JOINS
                WHERE
                  JOINS.RESERVE_ID = :reserveId AND
                  USERS.FACEBOOK_ID = JOINS.FACEBOOK_ID
            ', ["reserveId"=> $val->id]);
            $val->user = $users;
        }
        return response()->json(["status"=>"ok", "data"=>$data]);
    }
}
