<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            // Lấy giá trị ngôn ngữ từ session
            $locale = Session::get('locale');
        } else {
            // Nếu không có, sử dụng giá trị mặc định từ config/app.php
            $locale = Config::get('app.locale');
            // Lưu vào session để dùng lần sau
            Session::put('locale', $locale);
        }

        // Set locale cho ứng dụng
        App::setLocale($locale);
        
        return $next($request);
    }
}
