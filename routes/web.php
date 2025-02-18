<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ZonesController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Api\CallsController;
use App\Http\Controllers\Api\ReportsController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('api/login/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('api/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', RoleMiddleware::class . ':administrador'])->group(function () {

    Route::resource('operators', OperatorController::class)->only(['index', 'show', 'edit', 'update', 'destroy', 'create', 'store']);
    Route::resource('zones', ZonesController::class)->only(['index', 'show', 'edit', 'update', 'destroy', 'create', 'store']);
    Route::resource('calls', CallsController::class)->only(['index', 'show']);
    Route::get('/calls', [CallsController::class, 'calls'])->name('calls.calls');
});

Route::get('api/login/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('api/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Route::get('reports/emergencies', action: [ReportsController::class, 'getEmergencies']);
// Route::get('reports/socials', [ReportsController::class, 'getSocials']);
// Route::get('reports/monitoring', [ReportsController::class, 'getMonitorings']);
// Route::get('reports/patients', [ReportsController::class, 'getAllPatients']);
// Route::get('reports/patients/{id}/history', [ReportsController::class, 'getPatientHistory']);
// Route::get('reports/scheduled-calls', [ReportsController::class, 'getScheduledCalls']);
// Route::get('reports/done-calls', [ReportsController::class, 'doneCalls']);
// Route::get('reports/scheduled-and-done-calls', [ReportsController::class, 'getScheduledAndDoneCalls']);


//     Route::get('reports/emergency-actions-by-zone/{zoneId}', [ReportsController::class, 'getEmergencyActionsByZone']);
//     Route::get('reports/patients-list', [ReportsController::class, 'getPatientsList']);
//     Route::get('reports/scheduled-calls-by-date/{date}', [ReportsController::class, 'getScheduledCallsByDate']);
//     Route::get('reports/done-calls-by-date/{date}', [ReportsController::class, 'getDoneCallsByDate']);
//     Route::get('reports/call-history-by-patient-and-type/{patientId}', [ReportsController::class, 'getCallHistoryByPatientAndType']);
require __DIR__ . '/auth.php';
