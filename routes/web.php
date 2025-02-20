<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ZonesController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Api\CallsController;
use App\Http\Controllers\Api\ReportsController;
use App\Livewire\AssignPatientsToOperator;
use App\Models\User;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect(route('login'));
})->name('home');

Route::get('api/login/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('api/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

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

Route::get('/operators', function () {
    $operators = User::where('role', 'operador')->get();
    return view('operators.operators', ['operators' => $operators]);
})->name('operators.index');

Route::post('/assign-patients', function (Request $request) {
    $operatorId = $request->input('operatorId');
    return redirect()->route('assign.patients', ['operatorId' => $operatorId]);
})->name('assign.patients.form');

Route::get('/assign-patients/{operatorId}', AssignPatientsToOperator::class)->name('assign.patients');

Route::post('/remove-patient', function (Request $request) {
    $operatorId = $request->input('operator_id');
    $patientId = $request->input('patient_id');

    $operator = User::find($operatorId);

    if ($operator) {
        $operator->patients()->detach($patientId);
    }

    return redirect()->route('operators.index');
})->name('remove.patient');

require __DIR__ . '/auth.php';
