<?php

use App\Http\Controllers\ZonesController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', RoleMiddleware::class . ':administrador'])->group(function () {

    Route::resource('operators', OperatorController::class)->only(['index', 'show', 'edit', 'update', 'destroy', 'create', 'store']);
    Route::resource('zones', ZonesController::class)->only(['index', 'show', 'edit', 'update', 'destroy', 'create', 'store']);

});



require __DIR__ . '/auth.php';
