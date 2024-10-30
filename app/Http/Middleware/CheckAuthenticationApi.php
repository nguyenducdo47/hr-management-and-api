<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthenticationApi
{
    public function handle(Request $request, Closure $next)
    {
        $currentToken = $request->bearerToken();

        if (!$currentToken) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is required'
            ], 401);
        }

        try {
            $user = Auth::guard('sanctum')->user();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is invalid'
            ], 401);
        }

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is invalid'
            ], 401);
        }

        return $next($request);
    }
}
