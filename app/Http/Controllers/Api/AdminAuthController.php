<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);


        if(!Auth::attempt($request->only('email','password'))){

            return response()->json([
                'message'=>'Invalid credentials'
            ],401);

        }


        $user = Auth::user();


        if(!$user->is_admin){

            return response()->json([
                'message'=>'Admin access only'
            ],403);

        }


        $token = $user->createToken('admin-token')->plainTextToken;


        return response()->json([

            'status'=>true,
            'message'=>'Admin login successful',

            'token'=>$token,

            'admin'=>$user

        ]);

    }
}