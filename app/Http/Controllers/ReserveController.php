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
            SELECT FIELDS.*
            FROM FIELDS, RESERVES, STADIUMS
            WHERE
              STADIUMS.ID = :id AND
              STADIUMS.ID = FIELDS.STADIUM_ID AND
              FIELDS.ID = RESERVES.FIELD_ID AND
              RESERVES.DATE = :date AND
              (
                (:time_from1 > RESERVES.TIME_FROM AND :time_from2 < RESERVES.TIME_TO) OR
                (:time_to1  > RESERVES.TIME_FROM AND :time_to2 < RESERVES.TIME_TO) OR
                (
                  (RESERVES.TIME_FROM > :time_from3 AND RESERVES.TIME_FROM < :time_to3) AND
                  (RESERVES.TIME_TO > :time_from4 AND RESERVES.TIME_TO < :time_to4)
                )OR
                (RESERVES.TIME_FROM = :time_from5 AND RESERVES.TIME_TO = :time_to5) OR
                (RESERVES.TIME_FROM = :time_from6 AND RESERVES.TIME_TO != :time_to6) OR
                (RESERVES.TIME_FROM != :time_from7 AND RESERVES.TIME_TO = :time_to7)
              ) AND
              FIELDS.type = :type
        ', ["id"=>$stadium, "date"=>$date,
            "time_from1"=>$timeFrom, "time_from2"=>$timeFrom, "time_from3"=>$timeFrom, "time_from4"=>$timeFrom, "time_from5"=>$timeFrom, "time_from6"=>$timeFrom, "time_from7"=>$timeFrom,
            "time_to1"=>$timeTo, "time_to2"=>$timeTo, "time_to3"=>$timeTo, "time_to4"=>$timeTo, "time_to5"=>$timeTo, "time_to6"=>$timeTo, "time_to7"=>$timeTo,
            "type"=>$type]);

        $query = "SELECT FIELDS.* FROM FIELDS, STADIUMS";
        $params = [];
        $query .= ' WHERE ';


        for($i = 0 ; $i < count($busyField) ; $i++){
            $query .= 'FIELDS.ID !=  :id' . $i . ' AND ';
            $params["id".$i] = $busyField[$i]->id;

        }
        $query .= 'FIELDS.TYPE = :type AND
         STADIUMS.ID = FIELDS.STADIUM_ID AND
          STADIUMS.ID = :stdid';
        $params["type"] = 'soccer';
        $params["stdid"] = $stadium;
        $freeStadium = DB::select($query, $params);

        return response()->json(["status"=>"ok", "data"=> $freeStadium]);
    }


    public function getMyReserve(){
        $facebookId = Input::get("facebookId");
        $all = DB::select('
        SELECT
            RESERVES.*, STADIUMS.NAME AS stadium_name, STADIUMS.latitude, STADIUMS.longitude, FIELDS.NAME AS field_name, STADIUMS.IMAGE as image
        FROM
            RESERVES, STADIUMS, FIELDS
        WHERE
            RESERVES.FACEBOOK_ID = :facebookId AND
            RESERVES.FIELD_ID = FIELDS.ID AND
            FIELDS.STADIUM_ID = STADIUMS.ID AND
            RESERVES.DATE >= NOW()
        ORDER BY
            RESERVES.DATE DESC
        ', ["facebookId" => $facebookId]);
        return response()->json(["status"=>"ok", "data"=>$all]);
    }

}
