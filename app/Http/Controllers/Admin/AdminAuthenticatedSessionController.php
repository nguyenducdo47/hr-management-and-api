<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('admin.auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $remember = $request->filled('remember');

    Auth::login(Auth::user(), $remember);

    $request->session()->regenerate();

    // Chuyển hướng đến admin dashboard nếu user là super_admin hoặc team_lead
    if (in_array(Auth::user()->role->name, ['super_admin', 'team_lead'])) {
        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    // Nếu không, chuyển hướng về trang người dùng bình thường
    return redirect()->intended(route('dashboard', absolute: false));
}


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin');
    }
}
