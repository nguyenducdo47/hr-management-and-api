<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetLanguageController;

use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Middleware\AdminRoleMiddleware;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;



use Illuminate\Support\Facades\Route;


Route::middleware(SetLocale::class)->group(function () {

    Route::get('/lang/vi', function () {
        Session::put('locale', 'vi');
        return redirect()->back();
    })->name('lang.vi');

    Route::get('/lang/en', function () {
        Session::put('locale', 'en');
        return redirect()->back();
    })->name('lang.en');


    // Route cho user
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });



    // Route cho admin
    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

        Route::get('/', function () {
            return view('admin.welcome');
        })->name('welcome');
        Route::middleware(AdminRoleMiddleware::class)->group(function () {


            Route::get('dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');

            Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');

            Route::resource('users', UsersController::class);
            Route::resource('tasks', TaskController::class);

            Route::get('access-denied', function () {
                return view('admin.access-denied');
            })->name('access-denied');
        });
    });

    require __DIR__ . '/auth.php';
});
