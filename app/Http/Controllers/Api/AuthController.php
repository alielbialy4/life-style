<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{

    /*public function index(){
        $users = User::all();
        return $users;
    }*/
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required|unique:users|max:255',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'phone'=>'required|max:255',
            'birthday'=>'required|date',
            'gender'=>'required|in:male,female',
            'tall'=>'required|numeric|min:0|max:255',
            'weight'=>'required|numeric|min:0|max:255'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request['password']),
            'phone'=>$request->phone,
            'birthday'=>$request->birthday,
            'gender'=>$request->gender,
            'tall'=>$request->tall,
            'weight'=>$request->weight
        ]);

        $token = $user->createToken('app token')->plainTextToken;

        return $this->sendResponse($user , $token);
    }

    //login

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::where('email',$request->email)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('app token')->plainTextToken;
                $user['age'] = $user->age;
                return $this->sendResponse($user , $token);
            }
            return "انت راجل مش جدع";
        }
        return " مش موجود";
    }

    //logout
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return  response()->json(203);

    }

}


