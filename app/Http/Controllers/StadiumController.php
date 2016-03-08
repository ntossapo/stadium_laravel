<?php

namespace App\Http\Controllers;

use App\Stadium;
use DB;
use Input;
use App\User;
use App\Http\Requests;
use App\Field;
class StadiumController extends Controller
{
    public function getAll($id, $type, $lat, $lng){
        $user = User::where('facebook_id', '=', $id);
        if($user->count() == 0)
            return response()->json(["status"=>"err", "err"=>"User Invalid"]);
        $result = array();
        $resultSet = Field::where('type', '=', $type)
            ->join('stadiums', 'stadiums.id', '=', 'fields.stadium_id')
            ->select("fields.*")
            ->groupBy('fields.stadium_id')
            ->orderBy(DB::raw('sqrt(pow(stadiums.latitude - '.$lat.', 2) - pow(stadiums.longitude - '. $lng .', 2))'), 'desc')
            ->get();

        foreach($resultSet as $object){
            $stadium = $object->stadium;
            $count = DB::select('
		SELECT
		COUNT(*) as count
		from user_location, stadiums
		where
		sqrt(pow(stadiums.latitude - user_location.latitude, 2) + pow(stadiums.longitude - user_location.longitude, 2)) <= 0.0006 and 
		stadiums.id = :id'
		, array("id"=>$stadium->id));
            $stadium->count = intval($count[0]->count);
            array_push($result, $stadium);
        }

        return response()->json(["status"=>"ok", "data"=>$result]);
    }

    public function getStadiumDetail($id, $type){
        $resultSetStadium = Stadium::where('id', '=', $id)->get();
        $resulSetPriceRate = DB::select("
            select min(price_rate.price) as max, max(price_rate.price) as min
            from price_rate, fields, stadiums
            where
            stadiums.id = fields.stadium_id and
            price_rate.field_id = fields.id and
            fields.type = :type and
            stadiums.id = :id
        ", array('type'=>$type, 'id'=>$id));
        $result = array('basic'=>$resultSetStadium[0], 'price'=>$resulSetPriceRate[0]);
        return response()->json(['status'=>'ok', 'data'=>$result]);
    }

    public function getAllReserveOfStadium(){
        $id = Input::get('id');
        $type = Input::get('type');

        $selected = DB::select('
        select reserves.*, fields.name
        from reserves, fields, stadiums
        where
          stadiums.id = :id and
          fields.type = :type and
          stadiums.id = fields.stadium_id and
          reserves.field_id = fields.id and
          reserves.date >= curdate()
        order by
          reserves.date asc
        ',["id"=>$id, "type"=>$type]);

        return response()->json(["status"=>"ok","data"=>$selected]);
    }
}
