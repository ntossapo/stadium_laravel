<?php

namespace App\Http\Controllers;

use App\Reserve;
use Illuminate\Http\Request;
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
            $reserve->field = $field;
            $reserve->time_from = $timeFrom;
            $reserve->time_to = $timeTo;
            $reserve->date = $date;
            $reserve->save();
            return response()->json(['status'=>'ok', 'data'=>$reserve->id]);
        }else{
            return response()->json(['status'=>'err', 'err'=>'user token invalid ' . $user ]);
        }
    }
}
