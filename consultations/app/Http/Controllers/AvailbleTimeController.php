<?php

namespace App\Http\Controllers;

use App\Models\Availble_Time;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Parser\Multiple;

class AvailbleTimeController extends Controller
{
    public function get_available_time(Request $request)
     {
       

       $input = $request->validate([
           "From" => "required",
           "To" => "required"
       ]);

$expert=Auth::guard('expert_api')->user();

$input['expert_id']=$expert->id;
$availableTime=Availble_Time::create($input);


     return $availableTime->with("expert")->get();


   }





    // public function get_available_time(Request $request)
    // {
    //     $expert_id=Auth::id();

    //     $day=DB::table('days')
    //     ->where('days','days.name','=',$request->day)
    //     ->get();

    //     $day_id=$day[0]->id;

    //     $res['day_id']=$day_id;
    //     $res['expert_id']=$expert_id;
    //     $res['From']=$request->From;
    //     $res['To']=$request->To;

    //     Availble_Time::create($res);
    //     return 'done';
    // }

}
