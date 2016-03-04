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
            select distinct reserves.*, stadiums.name as stadiumname, stadiums.latitude as latitude, stadiums.longitude as longitude, fields.name as fieldname, stadiums.image as image, users.name as username
            from reserves, stadiums, fields, users, joins
            where
              users.facebook_id = reserves.facebook_id and
              reserves.facebook_id != :facebook and
              reserves.field_id = fields.id and
              fields.stadium_id = stadiums.id and
              fields.type = :type and
              reserves.isconfirm = 1 and
              reserves.date >= curdate() and
              (select count(*) from joins where joins.reserve_id = reserves.id and joins.facebook_id = :facebook2) != 1
              order by sqrt(pow(stadiums.latitude - :lat, 2) + pow(stadiums.longitude - :long, 2)) asc, reserves.date asc, reserves.time_from asc
              limit 30
        ', ["lat"=>$lat, "long"=>$long, "type"=>$type, "facebook"=>$user, "facebook2"=>$user]);

        foreach($data as $key=>$val){
            if($val->isjoin == 1) {
                unset($data[$key]);
                continue;
            }
            $users = DB::SELECT('
                select users.name as name
                from users, joins
                where
                  joins.reserve_id = :reserveid and
                  users.facebook_id = joins.facebook_id
            ', ["reserveid"=> $val->id]);
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
