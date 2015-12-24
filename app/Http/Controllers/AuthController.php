<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;

class AuthController extends Controller
{
    public function Auth(){
        $facebookId = Input::get("facebook_id");
        $facebookToken = Input::get("facebook_token");
        $name = Input::get("name");
        $picurl = Input::get("picurl");

        $query = User::where('facebook_id', $facebookId);
        $user = null;

        if($query->count() == 1){
            $user = $query->first();
        }else{
            $user = new User();
        }

        $user->facebook_token = $facebookToken;
        $user->facebook_id = $facebookId;
        $user->name = $name;
        $user->picurl = $picurl;
        $user->save();
        return response()->json(["status"=>"ok", "data"=>$user]);
    }
}
