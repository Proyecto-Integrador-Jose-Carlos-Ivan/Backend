<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Call;
use App\Models\Patient;
use App\Models\Alert;
use Illuminate\Support\Facades\View; // Import View


class ReportsController extends Controller
{
    private function applyDateFilters($query, $startDate, $endDate)
    {
        return $query->whereBetween('fecha_hora', [$startDate, $endDate]);
    }

    private function applyTypeFilter($query, $type, $isIncoming)
    {
        $relation = $isIncoming ? 'entrante' : 'saliente';
        return $query->whereHas($relation, function ($q) use ($type) {
            $q->where('type', $type);
        });
    }

    private function generatePdf($view, $data, $filename)
    {
        $dompdf = new Dompdf();
        $html = View::make($view, $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

    public function getEmergencies(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();
        $type = $request->query('type');

        $callsQuery = Call::query();
        $callsQuery = $this->applyDateFilters($callsQuery, $startDate, $endDate);
        if ($type) {
            $callsQuery = $this->applyTypeFilter($callsQuery, $type, true);
        }
        $calls = $callsQuery->get();

        $data = compact('calls', 'startDate', 'endDate');
        return $this->generatePdf('reports.emergencies', $data, 'emergencies_report.pdf');
    }

    public function getSocials(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();
        $type = $request->query('type');

        $callsQuery = Call::query();
        $callsQuery = $this->applyDateFilters($callsQuery, $startDate, $endDate);
        if ($type) {
            $callsQuery = $this->applyTypeFilter($callsQuery, $type, true);
        }
        $calls = $callsQuery->get();

        $data = compact('calls', 'startDate', 'endDate');
        return $this->generatePdf('reports.socials', $data, 'socials_report.pdf');
    }

    public function getMonitorings(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();
        $type = $request->query('type');

        $callsQuery = Call::query();
        $callsQuery = $this->applyDateFilters($callsQuery, $startDate, $endDate);
        if ($type) {
            $callsQuery = $this->applyTypeFilter($callsQuery, $type, false);
        }
        $calls = $callsQuery->get();

        $data = compact('calls', 'startDate', 'endDate');
        return $this->generatePdf('reports.monitoring', $data, 'monitoring_report.pdf');
    }

    public function getAllPatients(Request $request)
    {
        $patients = Patient::query();

        foreach ($request->query() as $key => $value) {
            $patients->where($key, $value);
        }

        $patients = $patients->get();
        $data = compact('patients');
        return $this->generatePdf('reports.patients', $data, 'patients_report.pdf');
    }

    public function getPatientHistory(Request $request, $id)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();
        $type = $request->query('type');

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


    public function getScheduledCalls(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();
        $zona_id = $request->query('zona_id') ?: null;

        if ($zona_id) {
            $alertsWithCalls = Alert::where('zona_id', $zona_id)->whereBetween('date', [$startDate, $endDate])->get();
            $alertsWithoutCalls = Alert::where('zona_id', $zona_id)->whereBetween('date', [$startDate, $endDate])->get();
        } else {
            $alertsWithCalls = Alert::whereBetween('fecha', [$startDate, $endDate])->get();
            $alertsWithoutCalls = Alert::whereBetween('fecha', [$startDate, $endDate])->get();
        }

        $data = compact('alertsWithCalls', 'alertsWithoutCalls', 'startDate', 'endDate');
        return $this->generatePdf('reports.scheduled_calls', $data, 'scheduled_calls_report.pdf');
    }

    public function doneCalls(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();
        $type = $request->query('type');

        $incomingCallsQuery = Call::query()->whereHas('entrante');
        $outgoingCallsQuery = Call::query()->whereHas('saliente');

        $incomingCallsQuery = $this->applyDateFilters($incomingCallsQuery, $startDate, $endDate);
        $outgoingCallsQuery = $this->applyDateFilters($outgoingCallsQuery, $startDate, $endDate);

        if ($type) {
            $incomingCallsQuery = $this->applyTypeFilter($incomingCallsQuery, $type, true);
            $outgoingCallsQuery = $this->applyTypeFilter($outgoingCallsQuery, $type, false);
        }

        $incomingCalls = $incomingCallsQuery->get();
        $outgoingCalls = $outgoingCallsQuery->get();

        $data = compact('incomingCalls', 'outgoingCalls', 'startDate', 'endDate');
        return $this->generatePdf('reports.done_calls', $data, 'done_calls_report.pdf');
    }
}