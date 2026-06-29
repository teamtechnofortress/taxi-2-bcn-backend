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
            'name'=>'required',
            'password'=>'required'
        ]);
        $user = User::where('name',$request->name)->first();
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
        $token = $user->createToken('admin-token')
                      ->plainTextToken;

        return response()->json([
            'status'=>true,
            'message'=>'Admin login successful',
            'token'=>$token,
            'admin'=>$user
        ]);
    }
}