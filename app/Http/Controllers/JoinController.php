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
            select reserves.*, stadiums.name as stadium_name,
              stadiums.latitude, stadiums.longitude,
              fields.name as field_name, stadiums.image as image,
              users.name as ownername, users.picurl as reserverimage,
              joins.id as joinid
            from joins, reserves, stadiums, fields, users
            where
              joins.facebook_id = :facebook and
              joins.reserve_id = reserves.id and
              reserves.field_id = fields.id and
              fields.stadium_id = stadiums.id and
              reserves.date >= curdate() and
              reserves.facebook_id = users.facebook_id
            order by
              reserves.date asc
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
