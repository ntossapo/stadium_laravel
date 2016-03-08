<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use DB;
class CheckInController extends Controller
{
    public function checkin(){
        $reserveId = Input::get("reserve_id");
        $lat = Input::get("lat");
        $lng = Input::get("lng");

//       $result = DB::select('select count(stadiums.name) from stadiums, ')
    }
}
