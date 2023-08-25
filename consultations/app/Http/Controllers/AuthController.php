<?php

namespace App\Http\Controllers;

use App\Models\Availble_Time;
use App\Models\consultations;
use App\Models\Expert;
use App\Models\expert_consul;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //// USER
    public function userRegister(Request $request){
        $request->validate([
            'user_name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'c_password'=>'required|same:password',
            'phone_num'=>'required',
            'wallet'=>'required'
        ]);
        $input=$request->all();
        $input['password']=Hash::make($input['password']);
        $input['token']=Str::random(60);

        $user=User::create($input);
        $accessToken=$user->createToken('MyApp',['user'])->accessToken;

        return response()->json([
            'user'=>$user,'accessToken'=>$accessToken
        ]);
    }


    public function userLogin(Request $request){
     $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);
        if(auth()->guard('user')->attempt($request->only('email','password'))){
             config(['auth.guards.user-api.provider'=>'users']);
             $user=User::query()->find(auth()->guard('user')->user()['id']);
             $success=$user;
             $success['token']=$user->createToken('MyApp',['user'])->accessToken;
            return response()->json($success);

        }
        else
        {
            return response()->json(['error'=>'unauthorized'],401);
        }
    }


    public function userLogout(Request $request){
        Auth::guard('user_api')->user()->token()->revoke();
        return response()->json(['success'=>'user logged out successfuly']);

    }

////////////////////////////////////////////////////////////////////////////////////////////////
////  EXPERT
public function expertRegister(Request $request){
        $request->validate([
            'expert_name'=>'required',
            'email'=>'required|email|unique:experts',
            'password'=>'required',
            'c_password'=>'required|same:password',
            'phone_num'=>'required|min:9|max:10',
            'wallet'=>'required',
            'Adress',
            'details'=>'required',
            'profile_img_url'=>['image','mimes:jpeg,png,gif,bmp,jpg,svg'],
            'consulPrice'=>'required',
            'cosultations.*'=>'required',
            'From'=>'required',
            'To'=>'required'
        ]);
        $input=$request->all();
        $input['password']=Hash::make($input['password']);
        $input['token']=Str::random(60);
        $input['profile_img_url'] = 'storage/'.$request->file('profile_img_url')->store('images','public');
        $expert = Expert::create($input);
        $accessToken=$expert->createToken('MyApp',['expert'])
        ->accessToken;
        ///////////////////////////////////////////
        $expert->consults()->attach($request->cosultations);
        ///////////////////////////////////////
        $availble_time=new Availble_Time();
        $availble_time->From=$request->From;
        $availble_time->To=$request->To;

        $expert->availableTimes()->save($availble_time);
        ///////////////////////////////////////

        return response()->json([
         'expert'=>$expert,
         'accessToken'=>$accessToken,
    ]);

    }


    public function expertLogin(Request $request){
        $request->validate([
               'email'=>'required',
               'password'=>'required',
           ]);
           if(auth()->guard('expert')->attempt($request->only('email','password'))){
                config(['auth.guards.user-api.provider'=>'experts']);
                $expert=Expert::query()->find(auth()->guard('expert')->user()['id']);
                $success=$expert;
                $success['token']=$expert->createToken('MyApp',['expert'])->accessToken;
               return response()->json($success);

           }else{
               return response()->json(['error'=>'unauthorized'],401);
           }
    }


    public function expertLogout(Request $request){
        Auth::guard('expert_api')->user()->token()->revoke();
        return response()->json(['success'=>'expert logged out successfuly']);
    }


}
