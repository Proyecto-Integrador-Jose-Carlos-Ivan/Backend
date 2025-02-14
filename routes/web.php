<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('api/login/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('api/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
