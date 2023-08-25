<?php

namespace App\Http\Controllers;

use App\Models\Availble_Time;
use App\Models\Expert;
use App\Models\favorites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{

    public function get_favorite(Request $request)
    {

        $user =Auth::guard('user_api')->user();
        $request->validate([
            'expert_id' => "required"
        ]);

        $expert = Expert::find($request->expert_id);
        $favorites = favorites::where('expert_id', '=', $expert->id)->where("user_id", '=', $user->id)->first();
        if( $favorites )
            return ["message" => 'expert is already exist in your favorite list'];

        $favorite = new favorites();
        $favorite->user()->associate($user);
        $favorite->expert()->associate($expert) ;
        $favorite->save();
        return $favorite->with(['user', 'expert'])->get();
    }

}
