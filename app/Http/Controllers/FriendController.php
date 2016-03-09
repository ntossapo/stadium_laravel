<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use DB;
class FriendController extends Controller
{
    public function getFriendStat(){
        $friendId = Input::get("id");
        $user = User::find($friendId);
        if(count($user) == 0)
            return response()->json(["status"=>"err", "err"=>"user not found"]);

        $result = DB::select('
            SELECT 
              (SELECT COUNT(reserves.*)  
              FROM reserves 
              WHERE reserves.facebook_id = :facebookid AND
              reserves.isConfirm = 1 AND
              reserves.isCheckIn = 1) 
              AS reservesAndPlay,
              
              (SELECT COUNT(reserves.*)
              FROM reserves
              WHERE reserves.facebook_id = :facebookid2 AND
              reserves.isConfirm = 1 AND 
              reserves.isCheckIn = 0)
              AS reservesAndMiss,
              
              (SELECT COUNT(reserves.*) 
              FROM reserves
              WHERE reserves.facebook_id = :facebookid3)
              AS allReserves
              
              (SELECT COUNT(joins.*)
              FROM joins
              WHERE joins.facebook_id = :facebookid4)
              AS allJoin
              ', ['facebookid' =>$friendId, 'facebookid2' =>$friendId, 'facebookid3'=>$friendId, 'facebookid4'=>$friendId]);

        $user->reservesAndPlay = $result->reservesAndPlay;
        $user->reservesAndMiss = $result->reservesAndMiss;
        $user->allReserves = $result->allReserves;
        $user->allJoin = $result->allJoin;
        return response()->json(['status'=>'ok', 'data'=>$user]);
    }
}
