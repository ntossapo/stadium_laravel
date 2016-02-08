<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use DB;
class PlayFriendController extends Controller
{
    public function getMatch(){
        $friends = json_decode(Input::get("friends"));
        $user = Input::get("facebook_id");
        $type = Input::get("type");
        $match = array();
        foreach((array)$friends as $friend){
            $result = DB::select('
                SELECT reserves.*, stadiums.name as stadiumName, stadiums.latitude as latitude,
                 stadiums.longitude as longitude, fields.name as fieldName, stadiums.image as image,
                 users.name as username
                From reserves, stadiums, fields, users
                WHERE
                  reserves.field_id = fields.id AND
                  stadiums.id = fields.stadium_id AND
                  reserves.facebook_id = users.facebook_id AND
                  users.facebook_id != :self1 AND
                  reserves.isConfirm = 1 AND
                  fields.type = :type and
                  NOT EXISTS (SELECT joins.facebook_id FROM joins WHERE joins.facebook_id = :self2) AND
                  reserves.facebook_id = :friend AND
                  reserves.date >= CURDATE()
                  ORDER BY reserves.date ASC
            ', ["self1"=>$user, "self2"=>$user, "friend"=>$friend->id, "type"=>$type]);

            foreach((array)$result as &$re){
                $peoples = DB::select('
                  SELECT USERS.NAME as name
                  FROM USERS, JOINS
                  WHERE
                    JOINS.RESERVE_ID = :reserveId AND
                    USERS.FACEBOOK_ID = JOINS.FACEBOOK_ID
                ', ["reserveId"=>$re->id]);
                $re->user = $peoples;
                array_push($match, $re);
            }
        }

        return response()->json(["status"=>"ok", "data"=>$match]);
    }

    public function joinFriendMatch(){
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
