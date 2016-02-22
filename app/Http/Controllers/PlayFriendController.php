<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Input;
use DB;
class PlayFriendController extends Controller
{
    public function getMatch(){
        $friends = json_decode(Input::get("friends"));
        $user = Input::get("facebook_id");
        $type = Input::get("type");
        $lat = Input::get("lat");
        $lng = Input::get("lng");
        $match = array();
        foreach((array)$friends as $friend){
            $result = DB::select('
                select reserves.*, stadiums.name as stadiumname, stadiums.latitude as latitude,
                 stadiums.longitude as longitude, fields.name as fieldname, stadiums.image as image,
                 users.name as username
                from reserves, stadiums, fields, users
                where
                  reserves.field_id = fields.id and
                  stadiums.id = fields.stadium_id and
                  reserves.facebook_id = users.facebook_id and
                  users.facebook_id != :self1 and
                  reserves.isconfirm = 1 and
                  fields.type = :type and
                  not exists (select joins.facebook_id from joins where joins.facebook_id = :self2) and
                  reserves.facebook_id = :friend and
                  reserves.date >= curdate()
                  order by reserves.date asc
            ', ["self1"=>$user, "self2"=>$user, "friend"=>$friend->id, "type"=>$type]);

            foreach((array)$result as &$re){
                $peoples = DB::select('
                  select users.name as name
                  from users, joins
                  where
                    joins.reserve_id = :reserveid and
                    users.facebook_id = joins.facebook_id
                ', ["reserveid"=>$re->id]);
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
