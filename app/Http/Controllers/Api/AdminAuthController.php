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
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        // Check if user is an admin
        if (!$user->is_admin) {
            return response()->json([
                'status' => false,
                'message' => 'Admin access only',
            ], 403);
        }

        // Delete any existing admin token
        $user->tokens()
            ->where('name', 'admin-token')
            ->delete();

        // Create a new token
        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Admin login successful',
            'token'   => $token,
            'admin'   => $user,
        ], 200);
    }
}