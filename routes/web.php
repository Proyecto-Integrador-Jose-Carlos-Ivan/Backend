<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google')->middleware(\App\Http\Middleware\CorsMiddleware::class);
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback')->middleware(\App\Http\Middleware\CorsMiddleware::class);