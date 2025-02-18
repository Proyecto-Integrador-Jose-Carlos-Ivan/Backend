<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientsController;
use App\Http\Controllers\Api\ContactsController;
use App\Http\Controllers\Api\CallsController;
use App\Http\Controllers\Api\AlertsController;
use App\Http\Controllers\Api\OperatorsController;
use App\Http\Controllers\Api\ZonesController;
use App\Http\Controllers\Api\ReportsController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return response()->json($request->user());
})->middleware('auth:sanctum','api');

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum','api'])->group(function () {

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
    Route::get('operators/{id}/calls', [OperatorsController::class, 'getCallHistoryByOperator']);
    Route::get('patients/{id}/calls', [PatientsController::class, 'getCallHistoryByPatient']);

    Route::get('reports/emergencies', action: [ReportsController::class, 'getEmergencies']);
    Route::get('reports/socials', [ReportsController::class, 'getSocials']);
    Route::get('reports/monitoring', [ReportsController::class, 'getMonitorings']);
    Route::get('reports/patients', [ReportsController::class, 'getAllPatients']);
    Route::get('reports/patients/{id}/history', [ReportsController::class, 'getPatientHistory']);
    Route::get('reports/scheduled-calls', [ReportsController::class, 'getScheduledCalls']);
    Route::get('reports/done-calls', [ReportsController::class, 'doneCalls']);
    



});