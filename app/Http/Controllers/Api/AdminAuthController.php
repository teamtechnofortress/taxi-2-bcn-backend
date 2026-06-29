<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
             'email'=>'required|email',
            'password'=>'required'
        ]);
        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password))
        {
            return response()->json([
                'message'=>'Invalid username or password'
            ],401);
        }
        if(!$user->is_admin)
        {
            return response()->json([
                'message'=>'Admin access only'
            ],403);
        }


           $token = $user->tokens()
                      ->where('name','admin-token')
                      ->first();
        if(!$token)
        {
            $token = $user->createToken('admin-token')
                          ->plainTextToken;

        }
        else
        {
            $token = $token->token;
            $token = $user->tokens()
                          ->where('name','admin-token')
                          ->first()
                          ->plainTextToken ?? $token;
        }
        return response()->json([
            'status'=>true,
            'message'=>'Admin login successful',
            'token'=>$token,
            'admin'=>$user
        ]);
    }
}