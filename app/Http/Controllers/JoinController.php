<?php

namespace App\Http\Controllers;

use App\Join;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Input;
class JoinController extends Controller
{
    public function getMyJoin(){
        $facebookId = Input::get("facebook_id");
        $result = DB::select('
            SELECT RESERVES.*, STADIUMS.NAME AS stadium_name,
              STADIUMS.latitude, STADIUMS.longitude,
              FIELDS.NAME AS field_name, STADIUMS.IMAGE as image,
              USERS.Name as ownername, USERS.picurl as reserverImage,
              JOINS.ID as joinId
            FROM JOINS, RESERVES, STADIUMS, FIELDS, USERS
            WHERE
              joins.facebook_id = :facebook AND
              joins.reserve_id = reserves.id AND
              reserves.field_id = fields.id AND
              fields.stadium_id = stadiums.id AND
              reserves.date >= CURDATE() AND
              reserves.facebook_id = users.facebook_id
            ORDER BY
              reserves.date ASC
        ', ["facebook"=>$facebookId]);
        return response()->json(["status"=>"ok", "data"=>$result]);
    }

    public function deleteMyJoin(){
        $id = Input::get("id");
        $item = Join::find($id);
        if($item != null) {
            $item->delete();
            return response()->json(["status"=>"ok"]);
        }else
            return response()->json(["status"=>"err", "err"=>"not found"]);
    }
}
