<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use DB;
use App\User;
class FriendController extends Controller
{
    public function getFriendStat(){
        $friendId = Input::get("id");
        $user = User::where("facebook_id", $friendId)->first();;
        if(count($user) == 0)
            return response()->json(["status"=>"err", "err"=>"user not found"]);

        $result = DB::select('
            SELECT 
              (SELECT COUNT(*)  
              FROM reserves 
              WHERE reserves.facebook_id = :facebookid AND
              reserves.isConfirm = 1 AND
              reserves.isCheckIn = 1) 
              AS reservesAndPlay,
              
              (SELECT COUNT(*)
              FROM reserves
              WHERE reserves.facebook_id = :facebookid2 AND
              reserves.isConfirm = 1 AND 
              reserves.isCheckIn = 0 AND
              datediff(now(), reserves.date) > 0)
              AS reservesAndMiss,
              
              (SELECT COUNT(*) 
              FROM reserves
              WHERE reserves.facebook_id = :facebookid3)
              AS allReserves,
              
              (SELECT COUNT(*)
              FROM joins
              WHERE joins.facebook_id = :facebookid4)
              AS allJoin
              ',
            [
                'facebookid' =>$user->facebook_id,
                'facebookid2' =>$user->facebook_id,
                'facebookid3'=>$user->facebook_id,
                'facebookid4'=>$user->facebook_id
            ]
        );
        
        $user->reservesAndPlay = $result[0]->reservesAndPlay;
        $user->reservesAndMiss = $result[0]->reservesAndMiss;
        $user->allReserves = $result[0]->allReserves;
        $user->allJoin = $result[0]->allJoin;
        return response()->json(['status'=>'ok', 'data'=>$user]);
    }
}
