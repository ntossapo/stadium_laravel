<?php

namespace App\Http\Controllers;

use App\Field;
use App\Reserve;
use DB;
use Input;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReserveController extends Controller
{
    public function Reserve(){
        $user = Input::get("user");
        $field = Input::get("field");
        $timeFrom = Input::get("time_from");
        $timeTo = Input::get('time_to');
        $date = Input::get('date');

        $userQuery = User::where('facebook_id', '=', $user);
        if($userQuery->count() == 1){
            $reserve = new Reserve();
            $reserve->facebook_id = $user;
            $reserve->field_id = $field;
            $reserve->time_from = $timeFrom;
            $reserve->time_to = $timeTo;
            $reserve->date = $date;
            $reserve->save();
            return response()->json(['status'=>'ok', 'data'=>$reserve->id]);
        }else{
            return response()->json(['status'=>'err', 'err'=>'user token invalid ' . $user ]);
        }

        return response()->json(['status'=>'ok']);
    }

    public function preReserve(){
        $timeFrom = Input::get("time_from");
        $timeTo = Input::get("time_to");
        $stadium = Input::get("stadium");
        $type = Input::get("type");
        $date = Input::get("date");

        $busyField = DB::select('
            select fields.*
            from fields, reserves, stadiums
            where
              stadiums.id = :id and
              stadiums.id = fields.stadium_id and
              fields.id = reserves.field_id and
              reserves.date = :date and
              (
                (:time_from1 > reserves.time_from and :time_from2 < reserves.time_to) or
                (:time_to1  > reserves.time_from and :time_to2 < reserves.time_to) or
                (
                  (reserves.time_from > :time_from3 and reserves.time_from < :time_to3) and
                  (reserves.time_to > :time_from4 and reserves.time_to < :time_to4)
                )or
                (reserves.time_from = :time_from5 and reserves.time_to = :time_to5) or
                (reserves.time_from = :time_from6 and reserves.time_to != :time_to6) or
                (reserves.time_from != :time_from7 and reserves.time_to = :time_to7)
              ) and
              fields.type = :type
        ', ["id"=>$stadium, "date"=>$date,
            "time_from1"=>$timeFrom, "time_from2"=>$timeFrom, "time_from3"=>$timeFrom, "time_from4"=>$timeFrom, "time_from5"=>$timeFrom, "time_from6"=>$timeFrom, "time_from7"=>$timeFrom,
            "time_to1"=>$timeTo, "time_to2"=>$timeTo, "time_to3"=>$timeTo, "time_to4"=>$timeTo, "time_to5"=>$timeTo, "time_to6"=>$timeTo, "time_to7"=>$timeTo,
            "type"=>$type]);

        $query = "select fields.* from fields, stadiums";
        $params = [];
        $query .= ' WHERE ';


        for($i = 0 ; $i < count($busyField) ; $i++){
            $query .= 'fields.id !=  :id' . $i . ' AND ';
            $params["id".$i] = $busyField[$i]->id;

        }
        $query .= 'fields.type = :type and
         stadiums.id = fields.stadium_id and
          stadiums.id = :stdid';
        $params["type"] = 'soccer';
        $params["stdid"] = $stadium;
        $freeStadium = DB::select($query, $params);

        return response()->json(["status"=>"ok", "data"=> $freeStadium]);
    }


    public function getMyReserve(){
        $facebookId = Input::get("facebookId");
        $all = DB::select('
        select
            reserves.*, stadiums.name as stadium_name, stadiums.latitude, stadiums.longitude, fields.name as field_name, stadiums.image as image
        from
            reserves, stadiums, fields
        where
            reserves.facebook_id = :facebookid and
            reserves.field_id = fields.id and
            fields.stadium_id = stadiums.id and
            reserves.date >= curdate()
        order by
            reserves.date asc
        ', ["facebookid" => $facebookId]);
        return response()->json(["status"=>"ok", "data"=>$all]);
    }
}
