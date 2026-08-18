<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function storeToken(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
        ]);

        $user = $request->user();

        if (!$user->is_admin) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $user->update([
            'expo_push_token' => $validated['token'],
        ]);

        return response()->json([
            'message' => 'Notification token saved successfully.',
        ]);
    }
}