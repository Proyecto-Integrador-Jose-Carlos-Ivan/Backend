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
})->middleware('auth:sanctum', 'api');

Route::get('reports/emergency-actions-by-zone/{zoneId}', action: [ReportsController::class, 'getEmergencyActionsByZone']);
Route::get('reports/scheduled-calls', [ReportsController::class, 'getScheduledCalls']);
Route::get('reports/done-calls-by-date/{date}', [ReportsController::class, 'getDoneCallsByDate']);
Route::get('reports/call-history-by-patient-and-type/{patientId}', [ReportsController::class, 'getCallHistoryByPatientAndType']);
Route::get('reports/patients-list', [ReportsController::class, 'getPatientsList']);
Route::get('reports/emergencies', [ReportsController::class, 'getEmergencies']);
Route::get('calls/historico', [ReportsController::class, 'getCallHistory']);
Route::get('calls/realizadas', [ReportsController::class, 'getCallsDone']);

Route::post('login', [AuthController::class, 'loginCredentials']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum', 'api');

Route::middleware(['auth:sanctum', 'api'])->group(function () {

    // Pacientes
    Route::apiResource('patients', PatientsController::class)->names([
        'index' => 'patients.api.index',
        'show' => 'patients.api.show',
        'edit' => 'patients.api.edit',
        'update' => 'patients.api.update',
        'destroy' => 'patients.api.destroy',
        'create' => 'patients.api.create',
        'store' => 'patients.api.store',
    ]);

    // Contactos de pacientes
    Route::get('patients/{id}/contacts', [ContactsController::class, 'index']);
    Route::post('patients/{id}/contacts', [ContactsController::class, 'store']);
    Route::apiResource('contacts', ContactsController::class)->except(['index', 'store']);


    // Llamadas
    Route::apiResource('calls', CallsController::class)->names([
        'index' => 'calls.api.index',
        'show' => 'calls.api.show',
        'edit' => 'calls.api.edit',
        'update' => 'calls.api.update',
        'destroy' => 'calls.api.destroy',
        'create' => 'calls.api.create',
        'store' => 'calls.api.store',
    ]);

    // Avisos / Alarmes
    Route::apiResource('alerts', AlertsController::class)->names([
        'index' => 'alerts.api.index',
        'show' => 'alerts.api.show',
        'edit' => 'alerts.api.edit',
        'update' => 'alerts.api.update',
        'destroy' => 'alerts.api.destroy',
        'create' => 'alerts.api.create',
        'store' => 'alerts.api.store',
    ]);

    // Operadores
    Route::apiResource('operators', OperatorsController::class)->names([
        'index' => 'operators.api.index',
        'show' => 'operators.api.show',
        'edit' => 'operators.api.edit',
        'update' => 'operators.api.update',
        'destroy' => 'operators.api.destroy',
        'create' => 'operators.api.create',
        'store' => 'operators.api.store',
    ]);

    // Zonas
    Route::apiResource('zones', ZonesController::class)->names([
        'index' => 'zones.api.index',
        'show' => 'zones.api.show',
        'edit' => 'zones.api.edit',
        'update' => 'zones.api.update',
        'destroy' => 'zones.api.destroy',
        'create' => 'zones.api.create',
        'store' => 'zones.api.store',
    ]);

    // Informes
    // Route::get('operators/{id}/calls', [OperatorsController::class, 'getCallHistoryByOperator']);
    // Route::get('patients/{id}/calls', [PatientsController::class, 'getCallHistoryByPatient']);

    // 
    // Route::get('reports/socials', [ReportsController::class, 'getSocials']);
    // Route::get('reports/monitoring', [ReportsController::class, 'getMonitorings']);
    // Route::get('reports/patients', [ReportsController::class, 'getAllPatients']);
    // Route::get('reports/patients/{id}/history', [ReportsController::class, 'getPatientHistory']);
    // Route::get('reports/scheduled-calls', [ReportsController::class, 'getScheduledCalls']);
    // Route::get('reports/done-calls', [ReportsController::class, 'doneCalls']);
    // Route::get('reports/scheduled-and-done-calls', [ReportsController::class, 'getScheduledAndDoneCalls']);



});