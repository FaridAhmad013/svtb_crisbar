<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\RyunnaAuth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
})->name('main');

Route::namespace('App\Http\Controllers\Auth')->group(function () {
    Route::prefix('login')->group(function(){
        Route::get('/', [AuthController::class, 'login'])->name('auth.login');
        Route::post('/login_process', [AuthController::class, 'login_process'])->name('auth.login_process');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


Route::get('/debug-middleware', function () {
    return 'Middleware loaded: ' . RyunnaAuth::class;
});

Route::prefix('admin')->middleware([RyunnaAuth::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/edit_profile', [ProfileController::class, 'edit_profile'])->name('profile.edit_profile');
    Route::put('/profile/updatepassword', [ProfileController::class, 'updatePassword'])->name('profile.updatepassword');
});


