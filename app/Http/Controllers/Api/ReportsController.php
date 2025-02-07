<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    // Informe de actuaciones por emergències
    public function emergencies(Request $request)
    {
        // Lógica para generar informe de emergencias
        return response()->json(['message' => 'Informe de emergencias']);
    }

    // Llistat de pacients ordenats per cognoms
    public function patients(Request $request)
    {
        // Lógica para generar listado de pacientes
        return response()->json(['message' => 'Listado de pacientes']);
    }
    
    // Informe de cridades previstes per a un dia
    public function scheduledCalls(Request $request)
    {
        // Lógica para obtener llamadas planificadas en una fecha específica
        return response()->json(['message' => 'Llamadas planificadas para el día']);
    }
    
    // Informe de cridades fetes per a un dia
    public function doneCalls(Request $request)
    {
        // Lógica para obtener llamadas realizadas en una fecha específica
        return response()->json(['message' => 'Llamadas realizadas para el día']);
    }
    
    // Històric de cridades d’un pacient
    public function patientHistory($id)
    {
        // Lógica para obtener el historial de llamadas de un paciente
        return response()->json(['message' => "Historial de llamadas para el paciente $id"]);
    }
}
