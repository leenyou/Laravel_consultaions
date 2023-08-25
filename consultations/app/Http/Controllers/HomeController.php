<?php

namespace App\Http\Controllers;

use App\Models\consultations;
use App\Models\Days;
use App\Models\Expert;
use App\Models\expert_consul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function list_consults()
    {
        //  $Consult=consultations::all();
        $Consult=consultations::all('name');
        return response()->json(['consultations'=>$Consult]);
    }

    public function getExperts() {
        return Expert::all();
    }

    public function search_Expert_Name( $name) {
      return  Expert::where('expert_name','like','%'.$name.'%') -> get();
    }

    public function get_AvailableTime_Expert(int $id) {
        return Expert::find($id)->load('availableTimes');
    }

    public function getExpert_details( $id) {
        $expert = DB::table('experts')->where('id', $id)->first();
        return $expert ;

    }

    public function get_booking_user($id) {

      //  return Expert::with("bookings")->where('id', $id)->get();
      return Expert::find($id)->load('bookings');
    }
    public function get_booking_expert($id) {

        //  return Expert::with("bookings")->where('id', $id)->get();
        return Expert::find($id)->load('booking');
      }

    public function getConsultByName(Request $request) {
        $data = $request->validate([
            'name' => 'required|string'
        ]);
        return consultations::with("experts")->where("name", 'like', '%'.$data['name'].'%')->get();
    }

    public function get_consults_with_experts() {

        return consultations::with("experts")->get();
    }


//////////////////////////////////////////////////////////////////////
    public function getConsultByid($id) {

       return consultations::with("experts")->where("id", $id)->get();
    //  return consultations::find($id)->get();
    }

////////////////////////////////////////////////////////////////////

public function getBooking($id) {
    $expert = Expert::find($id) ;
    if(!$expert)
        return [ "message" => "unvalid user"];
    return $expert->bookings()->get();


}

}
