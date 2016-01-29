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
                (RESERVES.TIME_FROM = :time_from5 AND RESERVES.TIME_TO = :time_to5)
              ) AND
              FIELDS.type = :type
        ', ["id"=>$stadium, "date"=>$date,
            "time_from1"=>$timeFrom, "time_from2"=>$timeFrom, "time_from3"=>$timeFrom, "time_from4"=>$timeFrom, "time_from5"=>$timeFrom,
            "time_to1"=>$timeTo, "time_to2"=>$timeTo, "time_to3"=>$timeTo, "time_to4"=>$timeTo, "time_to5"=>$timeTo,
            "type"=>$type]);

        $query = "SELECT FIELDS.* FROM FIELDS, STADIUMS";
        $params = [];
        $query .= ' WHERE ';


        for($i = 0 ; $i < count($busyField) ; $i++){
            $query .= 'FIELDS.ID !=  :id' . $i . ' AND ';
            $params["id".$i] = $busyField[$i]->id;

        }
        $query .= 'FIELDS.TYPE = :type AND STADIUMS.ID = FIELDS.STADIUM_ID AND STADIUMS.ID = :stdid';
        $params["type"] = 'soccer';
        $params["stdid"] = 1;
        $freeStadium = DB::select($query, $params);

        return response()->json(["status"=>"ok", "data"=> $freeStadium]);
    }


    public function getAllField(){

        $timeFrom = '09:30:00';
        $timeTo = '10:30:00';
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
                (RESERVES.TIME_FROM = :time_from5 AND RESERVES.TIME_TO = :time_to5)
              ) AND
              FIELDS.type = :type
        ', ["id"=>1, "date"=>'2559-01-10',
            "time_from1"=>$timeFrom, "time_from2"=>$timeFrom, "time_from3"=>$timeFrom, "time_from4"=>$timeFrom, "time_from5"=>$timeFrom,
            "time_to1"=>$timeTo, "time_to2"=>$timeTo, "time_to3"=>$timeTo, "time_to4"=>$timeTo, "time_to5"=>$timeTo,
            "type"=>'soccer']);

        $query = "SELECT FIELDS.* FROM FIELDS, STADIUMS";
        $params = [];
        $query .= ' WHERE ';


        for($i = 0 ; $i < count($busyField) ; $i++){
            $query .= 'FIELDS.ID !=  :id' . $i . ' AND ';
            $params["id".$i] = $busyField[$i]->id;

        }
        $query .= 'FIELDS.TYPE = :type AND STADIUMS.ID = FIELDS.STADIUM_ID AND STADIUMS.ID = :stdid';
        $params["type"] = 'soccer';
        $params["stdid"] = 1;
        $freeStadium = DB::select($query, $params);

        return response()->json(["status"=>"ok", "data"=> $freeStadium]);
    }
}
