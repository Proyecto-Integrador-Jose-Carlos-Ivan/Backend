<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientsController;
use App\Http\Controllers\Api\ContactsController;
use App\Http\Controllers\Api\CallsController;
use App\Http\Controllers\Api\AlertsController;
use App\Http\Controllers\Api\OperatorsController;
use App\Http\Controllers\Api\ZonesController;
use App\Http\Controllers\Api\ReportsController;


Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', function (Request $request) {
    return response()->json($request->user());
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    // Pacientes
    Route::apiResource('patients', PatientsController::class);

    // Contactos de pacientes
    Route::get('patients/{id}/contacts', [ContactsController::class, 'index']);
    Route::post('patients/{id}/contacts', [ContactsController::class, 'store']);
    Route::apiResource('contacts', ContactsController::class)->except(['index', 'store']);

    // Llamadas
    Route::apiResource('calls', CallsController::class);

    // Avisos / Alarmes
    Route::apiResource('alerts', AlertsController::class);

    // Operadores
    Route::apiResource('operators', OperatorsController::class);

    // Zonas
    Route::apiResource('zones', ZonesController::class);

    // Informes
    Route::get('reports/emergencies', [ReportsController::class, 'emergencies']);
    Route::get('reports/patients', [ReportsController::class, 'patients']);
    Route::get('reports/scheduled-calls', [ReportsController::class, 'scheduledCalls']);
    Route::get('reports/done-calls', [ReportsController::class, 'doneCalls']);
    Route::get('reports/patient-history/{id}', [ReportsController::class, 'patientHistory']);
});