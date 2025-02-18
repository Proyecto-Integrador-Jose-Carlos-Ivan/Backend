<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReportService;

class ReportsController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

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
    
    // Informe de cridades previstes per a un dia amb filtres i exportació
    public function scheduledCalls(Request $request)
    {
        // Recollida dels filtres
        $date = $request->query('date');
        $zone = $request->query('zone');
        $callType = $request->query('call_type');
        $export = $request->query('export');

        // Exemple de dades fictícies
        $data = [
            ['id' => 1, 'date' => '2025-02-18', 'zone' => 'North', 'type' => 'scheduled', 'detail' => 'Llamada 1'],
            // ... altre dades
        ];

        // Aplicació dels filtres
        if ($date) {
            $data = array_filter($data, fn($item) => $item['date'] === $date);
        }
        if ($zone) {
            $data = array_filter($data, fn($item) => $item['zone'] === $zone);
        }
        if ($callType) {
            $data = array_filter($data, fn($item) => $item['type'] === $callType);
        }

        // Exportació de dades en PDF o CSV
        if ($export === 'pdf') {
            return $this->reportService->exportToPdf('scheduled_calls', $data);
        } elseif ($export === 'csv') {
            $csvContent = "id,date,zone,type,detail\n";
            foreach ($data as $row) {
                $csvContent .= "{$row['id']},{$row['date']},{$row['zone']},{$row['type']},{$row['detail']}\n";
            }
            return response($csvContent, 200)
                    ->header('Content-Type', 'text/csv')
                    ->header('Content-Disposition', 'attachment; filename="scheduled_calls.csv"');
        }
        
        return response()->json([
            'message' => 'Llamadas planificadas para el día',
            'data' => array_values($data)
        ]);
    }
    
    // Informe de cridades fetes per a un dia amb filtres i exportació
    public function doneCalls(Request $request)
    {
        // Recollida dels filtres
        $date = $request->query('date');
        $zone = $request->query('zone');
        $callType = $request->query('call_type');
        $export = $request->query('export');

        // Exemple de dades fictícies
        $data = [
            ['id' => 1, 'date' => '2025-02-18', 'zone' => 'South', 'type' => 'done', 'detail' => 'Llamada A'],
            // ... altre dades
        ];

        // Aplicació dels filtres
        if ($date) {
            $data = array_filter($data, fn($item) => $item['date'] === $date);
        }
        if ($zone) {
            $data = array_filter($data, fn($item) => $item['zone'] === $zone);
        }
        if ($callType) {
            $data = array_filter($data, fn($item) => $item['type'] === $callType);
        }

        // Exportació de dades en PDF o CSV
        if ($export === 'pdf') {
            return $this->reportService->exportToPdf('done_calls', $data);
        } elseif ($export === 'csv') {
            $csvContent = "id,date,zone,type,detail\n";
            foreach ($data as $row) {
                $csvContent .= "{$row['id']},{$row['date']},{$row['zone']},{$row['type']},{$row['detail']}\n";
            }
            return response($csvContent, 200)
                    ->header('Content-Type', 'text/csv')
                    ->header('Content-Disposition', 'attachment; filename="done_calls.csv"');
        }
        
        return response()->json([
            'message' => 'Llamadas realizadas para el día',
            'data' => array_values($data)
        ]);
    }
    
    // Històric de cridades d’un pacient amb filtres i exportació
    public function patientHistory(Request $request, $id)
    {
        // Recollida dels filtres
        $date = $request->query('date');
        $zone = $request->query('zone');
        $callType = $request->query('call_type');
        $export = $request->query('export');

        // Exemple de dades fictícies
        $data = [
            ['id' => 1, 'patient_id' => $id, 'date' => '2025-02-18', 'zone' => 'East', 'type' => 'done', 'detail' => 'Llamada X'],
            // ... altre dades
        ];

        // Aplicació dels filtres
        if ($date) {
            $data = array_filter($data, fn($item) => $item['date'] === $date);
        }
        if ($zone) {
            $data = array_filter($data, fn($item) => $item['zone'] === $zone);
        }
        if ($callType) {
            $data = array_filter($data, fn($item) => $item['type'] === $callType);
        }

        // Exportació de dades en PDF o CSV
        if ($export === 'pdf') {
            return $this->reportService->exportToPdf('patient_history', $data);
        } elseif ($export === 'csv') {
            $csvContent = "id,patient_id,date,zone,type,detail\n";
            foreach ($data as $row) {
                $csvContent .= "{$row['id']},{$row['patient_id']},{$row['date']},{$row['zone']},{$row['type']},{$row['detail']}\n";
            }
            return response($csvContent, 200)
                    ->header('Content-Type', 'text/csv')
                    ->header('Content-Disposition', 'attachment; filename="patient_history.csv"');
        }
        
        return response()->json([
            'message' => "Historial de llamadas para el paciente $id",
            'data' => array_values($data)
        ]);
    }
}