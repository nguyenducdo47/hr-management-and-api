<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userRole = Auth::user()->role->name ?? '';

        // Chỉ cho phép 'super_admin' và 'team_lead' truy cập
        if (!in_array($userRole, ['super_admin', 'team_lead'])) {
            return redirect()->route('admin.access-denied');
        }
        return $next($request);
    }
}
