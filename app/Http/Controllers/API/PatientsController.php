<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    public function index(Request $request)
    {
        // Listar pacientes, opcionalmente filtrados por zona
        $patients = Paciente::all();
        return response()->json($patients);
    }

    public function store(Request $request)
    {
        $patient = Paciente::create($request->all());
        return response()->json($patient, 201);
    }

    public function show($id)
    {
        $patient = Paciente::findOrFail($id);
        return response()->json($patient);
    }

    public function update(Request $request, $id)
    {
        $patient = Paciente::findOrFail($id);
        $patient->update($request->all());
        return response()->json($patient);
    }

    public function destroy($id)
    {
        $patient = Paciente::findOrFail($id);
        $patient->delete();
        return response()->json(null, 204);
    }
}
