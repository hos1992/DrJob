<?php

use Illuminate\Support\Facades\Route;


Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [\App\Http\Controllers\AuthController::class, 'authenticate'])->name('authenticate');


Route::middleware('CheckAuthUser')->group(function () {

    // logout route
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    // home
    Route::get('/', [\App\Http\Controllers\MainController::class, 'home'])->name('home');


});
