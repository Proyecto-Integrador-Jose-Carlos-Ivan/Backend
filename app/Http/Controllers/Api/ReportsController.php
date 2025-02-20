<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Call;
use App\Models\Patient;
use App\Models\Alert;
use App\Models\Zone;
use Illuminate\Support\Facades\View; // Import View


class ReportsController extends Controller
{
    private function applyDateFilters($query, $startDate, $endDate, $dateField = 'fecha_hora')
    {
        return $query->whereBetween($dateField, [$startDate, $endDate]);
    }

    private function applyTypeFilter($query, $type, $isIncoming)
    {
        $relation = $isIncoming ? 'entrante' : 'saliente';
        return $query->whereHas($relation, function ($q) use ($type) {
            $q->where('sentido', $type);
        });
    }

    private function generatePdf($view, $data, $filename)
    {
        $dompdf = new Dompdf();
        $html = View::make($view, $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $response = response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }

    public function getEmergencies(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();
        $zona_id = $request->query('zona');

        $callsQuery = Call::query();

        if ($zona_id) {
            $callsQuery->where('zone_id', $zona_id);
        }

        if ($startDate && $endDate) {
            $callsQuery->whereBetween('fecha_hora', [$startDate, $endDate]);
        }
        $callsQuery->where('categoria', 'atencion_emergencias');

        $calls = $callsQuery->get();

        $data = compact('calls', 'startDate', 'endDate', 'zona_id');
        return $this->generatePdf('reports.emergencies', $data, 'emergencies_report.pdf');
    }

    public function getSocials(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();
        $type = $request->query('sentido');

        $callsQuery = Call::query();
        $callsQuery = $this->applyDateFilters($callsQuery, $startDate, $endDate);
        if ($type) {
            $callsQuery = $this->applyTypeFilter($callsQuery, $type, true);
        }
        $calls = $callsQuery->get();

        $data = compact('calls', 'startDate', 'endDate');
        return $this->generatePdf('reports.socials', $data, 'socials_report.pdf');
    }

    public function getAllPatients(Request $request)
    {
        $patients = Patient::query()
            ->orderBy('apellidos')
            ->get();

        $data = compact('patients');
        return $this->generatePdf('reports.patients', $data, 'patients_report.pdf');
    }

    public function getPatientHistory(Request $request, $id)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();
        $type = $request->query('sentido');

        $callsQuery = Call::where('patientId', $id);
        $callsQuery = $this->applyDateFilters($callsQuery, $startDate, $endDate);
        if ($type) {
            $callsQuery = $this->applyTypeFilter($callsQuery, $type, true);
        }
        $calls = $callsQuery->get();

        $patient = Patient::find($id);
        $data = compact('calls', 'patient', 'startDate', 'endDate');
        return $this->generatePdf('reports.patient_history', $data, 'patient_history_report.pdf');
    }

    public function getEmergencyActionsByZone(Request $request, $zoneId)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();

        $callsQuery = Call::where('zone_id', $zoneId)
            ->where('categoria', 'atencion_emergencias')
            ->whereBetween('fecha_hora', [$startDate, $endDate]);

        $calls = $callsQuery->get();

        $zone = Zone::find($zoneId);

        $data = compact('calls', 'startDate', 'endDate', 'zone');
        return $this->generatePdf('reports.emergency_actions_by_zone', $data, 'emergency_actions_by_zone_report.pdf');
    }

    public function getPatientsList(Request $request)
    {
        $patients = Patient::orderBy('apellidos')->get();

        $data = compact('patients');
        return $this->generatePdf('reports.patients_list', $data, 'patients_list_report.pdf');
    }

    public function getScheduledCalls(Request $request)
    {
        $zona_id = $request->query('zona') ?: null;

        $fecha = $request->query('fecha') ? Carbon::parse($request->query('fecha'))->startOfDay() : Carbon::parse('1800-01-01')->startOfDay();

        $callsQuery = Call::query();

        // dd($fecha);
        if($fecha != '1800-01-01'){
            $callsQuery->where('fecha_hora', '>=', $fecha);
        }

        if ($zona_id) {
            $callsQuery->where('zone_id', $zona_id);
        }

        $calls = $callsQuery->get();

        $data = compact('calls');
        return $this->generatePdf('reports.scheduled_calls', $data, 'scheduled_calls_report.pdf');
    }

    public function getCallHistoryByPatientAndType(Request $request, $patientId)
    {
        $type = $request->query('tipo') ?: null;

        $callsQuery = Call::where('paciente_id', $patientId);

        if ($type) {
            $callsQuery->where('categoria', $type); 
        }

        $calls = $callsQuery->get();
        $patient = Patient::find($patientId);

        $data = compact('calls', 'patient', 'tipo');
        return $this->generatePdf('reports.call_history_by_patient_and_type', $data, 'call_history_by_patient_and_type_report.pdf');
    }
}