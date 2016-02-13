<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Input;
use App\Http\Requests;
use App\Join;
class QuickController extends Controller
{
    public function getQuickMatch(){
        $lat = Input::get("lat");
        $long = Input::get("long");
        $type = Input::get("type");
        $user = Input::get("facebookId");

        $data = DB::select('
            SELECT RESERVES.*, STADIUMS.NAME as stadiumName, STADIUMS.LATITUDE as latitude, STADIUMS.LONGITUDE as longitude, FIELDS.NAME as fieldName, STADIUMS.IMAGE as image, USERS.NAME as username
            , (SELECT COUNT(JOINS.FACEBOOK_ID) FROM JOINS WHERE JOINS.FACEBOOK_ID = :facebook2) AS isJoin
            FROM RESERVES, STADIUMS, FIELDS, USERS
            WHERE
              USERS.FACEBOOK_ID = RESERVES.FACEBOOK_ID AND
              RESERVES.FACEBOOK_ID != :facebook AND
              RESERVES.FIELD_ID = FIELDS.ID AND
              FIELDS.STADIUM_ID = STADIUMS.ID AND
              FIELDS.TYPE = :type AND
              reserves.isConfirm = 1 AND
              RESERVES.DATE >= CURDATE()
              ORDER BY SQRT(POW(STADIUMS.LATITUDE - :lat, 2) + POW(STADIUMS.LONGITUDE - :long, 2)) ASC, RESERVES.DATE ASC, RESERVES.TIME_FROM ASC
        ', ["lat"=>$lat, "long"=>$long, "type"=>$type, "facebook"=>$user, "facebook2"=>$user]);

        foreach($data as $key=>$val){
            if($val->isJoin == 1) {
                unset($data[$key]);
                continue;
            }
            $users = DB::SELECT('
                SELECT USERS.NAME as name
                FROM USERS, JOINS
                WHERE
                  JOINS.RESERVE_ID = :reserveId AND
                  USERS.FACEBOOK_ID = JOINS.FACEBOOK_ID
            ', ["reserveId"=> $val->id]);
            $val->user = $users;
        }
        return response()->json(["status"=>"ok", "data"=>$data]);
    }

    public function joinQuickMatch(){
        $facebook_id = Input::get("facebook_id");
        $reserve_id = Input::get("reserve_id");
        $exist = Join::where("facebook_id", "=", $facebook_id)
                    ->where("reserve_id", "=", $reserve_id)->count();

        if($exist == 0){
            $join = new Join();
            $join->facebook_id = $facebook_id;
            $join->reserve_id = $reserve_id;
            $join->save();
            return response()->json(["status"=>"ok"]);
        }else{
            return response()->json(["status"=>"err", "err"=>"join exist"]);
        }
    }
}
