<?php

namespace App\Http\Controllers;

use App\Stadium;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Field;
class ReserveController extends Controller
{
    public function getAll($id, $type){
        $user = User::where('facebook_id', '=', $id);
        if($user->count() == 0)
            return response()->json(["status"=>"err", "err"=>"User Invalid"]);
        $result = array();
        $query = Field::where('type', '=', $type)
            ->join('stadiums', 'stadiums.id', '=', 'fields.stadium_id')
            ->select("fields.*")
            ->groupBy('fields.stadium_id')
            ->get();

        foreach($query as $object){
            $stadium = $object->stadium;
            array_push($result, $stadium);
        }

        return response()->json(["status"=>"ok", "data"=>$result]);
    }
}
