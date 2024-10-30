<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API')->plainTextToken;

            return response()->json(['status' => 'true', 'access_token' => $token]);
        }

        return response()->json(['status' => 'false', 'message' => 'Unauthorized access. Please log in.'], 401);
    }


    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['status' => 'false', 'message' => 'Unauthorized access. Please log in.'], 401);
        }

        $user->currentAccessToken()->delete();

        return response()->json(['status' => 'true', 'message' => 'Logged out successfully']);
    }
}
