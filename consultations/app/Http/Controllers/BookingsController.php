<?php

namespace App\Http\Controllers;

use App\Models\bookings;
use App\Models\Expert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingsController extends Controller
{

    public function booking(Request $request)
    {
        $user = Auth::guard('user_api')->user();
        //
         $request->validate([
            "expert_id" => "required",
            "from" => "required" ,
            "to" => "required"
        ]);


        $expert = Expert::find( $request->expert_id);
        $availableTimes =$expert->availableTimes()->get();

        $from_date = Carbon::parse($request->from);
        $to_date = Carbon::parse($request->to);

        if($from_date->gt($to_date)) {
            return [ "message" => "from date must be less than to data"];
        }

        $expertHasAvailableTime = false;

        foreach($availableTimes as $availableTime) {
            $expert_from_date = Carbon::parse($availableTime->From);
            $expert_to_date = Carbon::parse($availableTime->To);
            if( $from_date->gte($expert_from_date) && $to_date->lte($expert_to_date)) {
                $expertHasAvailableTime = true;
                break;
            }
        }

        $all_reservations = bookings::where("from", '>', now())->get();
        $hasPreviousReservation = false;
        foreach ($all_reservations as $reservation) {
            $booking_from_date = Carbon::parse($reservation->from);
            $booking_to_date = Carbon::parse($reservation->to);
            if($from_date->lte($booking_to_date) && $booking_from_date->lte($to_date)) {
                $hasPreviousReservation = true;
                break;
            }
        }


        if(!$expertHasAvailableTime || $hasPreviousReservation) {
            return [ 'message' => "this time is not available"] ;
        }

        if( $user->wallet < $expert->consulPrice) {
            return ["message" => "your must have greater than" . $expert->consult_price . 'to continue'];
        }

        $booking = new bookings();
        $booking->from = $request->from;
        $booking->to = $request->to;
        $user->wallet -= $expert->consulPrice;
        $expert->wallet += $expert->consulPrice;
        $booking->user()->associate($user);
        $booking->expert()->associate($expert);
        $booking->save();
        $user->save();
        $expert->save();

        return $booking->with(["user", 'expert'])->get();

    }

}
