<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Call;
use App\Models\Patient;
use App\Models\Alert;
use App\Models\Zone;
use Illuminate\Support\Facades\View;

/**
 * @OA\Tag(
 *   name="Reports",
 *   description="Operaciones relacionadas con la generación de informes."
 * )
 */
class ReportsController extends Controller
{
    /**
     * Aplica filtros de fecha a una consulta.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $startDate
     * @param  string  $endDate
     * @param  string  $dateField
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function applyDateFilters($query, $startDate, $endDate, $dateField = 'fecha_hora')
    {
        return $query->whereBetween($dateField, [$startDate, $endDate]);
    }

    /**
     * Aplica filtros de tipo a una consulta.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @param  bool  $isIncoming
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function applyTypeFilter($query, $type, $isIncoming)
    {
        $relation = $isIncoming ? 'entrante' : 'saliente';
        return $query->whereHas($relation, function ($q) use ($type) {
            $q->where('sentido', $type);
        });
    }

    /**
     * Genera un PDF a partir de una vista y datos.
     *
     * @param  string  $view
     * @param  array  $data
     * @param  string  $filename
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Genera un informe de emergencias.
     *
     * @OA\Get(
     *     path="/api/reports/emergencies",
     *     summary="Genera un informe de emergencias",
     *     description="Genera un informe de emergencias filtrado por fecha y zona.",
     *     tags={"Reports"},
     *     @OA\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Fecha de inicio para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Fecha de fin para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="zona",
     *         in="query",
     *         description="ID de la zona para el filtro.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informe generado exitosamente."
     *     )
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Genera un informe de acciones sociales.
     *
     * @OA\Get(
     *     path="/api/reports/socials",
     *     summary="Genera un informe de acciones sociales",
     *     description="Genera un informe de acciones sociales filtrado por fecha y tipo.",
     *     tags={"Reports"},
     *     @OA\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Fecha de inicio para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Fecha de fin para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="sentido",
     *         in="query",
     *         description="Tipo de acción social para el filtro.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informe generado exitosamente."
     *     )
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Genera un informe de monitorizaciones.
     *
     *  @OA\Get(
     *     path="/api/reports/monitorings",
     *     summary="Genera un informe de monitorizaciones",
     *     description="Genera un informe de monitorizaciones filtrado por fecha y tipo.",
     *     tags={"Reports"},
     *     @OA\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Fecha de inicio para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Fecha de fin para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="sentido",
     *         in="query",
     *         description="Tipo de monitorización para el filtro.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informe generado exitosamente."
     *     )
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getMonitorings(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();
        $type = $request->query('sentido');

        $callsQuery = Call::query();
        $callsQuery = $this->applyDateFilters($callsQuery, $startDate, $endDate);
        if ($type) {
            $callsQuery = $this->applyTypeFilter($callsQuery, $type, false);
        }
        $calls = $callsQuery->get();

        $data = compact('calls', 'startDate', 'endDate');
        return $this->generatePdf('reports.monitoring', $data, 'monitoring_report.pdf');
    }

    /**
     * Genera un informe de todos los pacientes, ordenados alfabéticamente por apellido.
     *
     *  @OA\Get(
     *     path="/api/reports/patients",
     *     summary="Genera un informe de todos los pacientes",
     *     description="Genera un informe de todos los pacientes, ordenados alfabéticamente por apellido.",
     *     tags={"Reports"},
     *     @OA\Response(
     *         response=200,
     *         description="Informe generado exitosamente."
     *     )
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllPatients(Request $request)
    {
        $patients = Patient::query()
            ->orderBy('apellidos')
            ->get();

        $data = compact('patients');
        return $this->generatePdf('reports.patients', $data, 'patients_report.pdf');
    }

    /**
     * Genera un informe del historial de un paciente.
     *
     *  @OA\Get(
     *     path="/api/reports/patient_history/{id}",
     *     summary="Genera un informe del historial de un paciente",
     *     description="Genera un informe del historial de un paciente filtrado por fecha y tipo.",
     *     tags={"Reports"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del paciente.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Fecha de inicio para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Fecha de fin para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="sentido",
     *         in="query",
     *         description="Tipo de acción para el filtro.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informe generado exitosamente."
     *     )
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Genera un informe de acciones de emergencia por zona.
     *
     * @OA\Get(
     *     path="/api/reports/emergency-actions-by-zone/{zoneId}",
     *     summary="Genera un informe de acciones de emergencia por zona",
     *     description="Genera un informe de acciones de emergencia por zona filtrado por fecha.",
     *     tags={"Reports"},
     *     @OA\Parameter(
     *         name="zoneId",
     *         in="path",
     *         description="ID de la zona.",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Fecha de inicio para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Fecha de fin para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informe generado exitosamente."
     *     )
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $zoneId
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Genera un listado de pacientes.
     *
     * @OA\Get(
     *     path="/api/reports/patients-list",
     *     summary="Genera un listado de pacientes",
     *     description="Genera un listado de pacientes ordenados por apellido.",
     *     tags={"Reports"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado generado exitosamente."
     *     )
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPatientsList(Request $request)
    {
        $patients = Patient::orderBy('apellidos')->get();

        $data = compact('patients');
        return $this->generatePdf('reports.patients_list', $data, 'patients_list_report.pdf');
    }

    /**
     * Genera un informe de llamadas programadas.
     *
     * @OA\Get(
     *     path="/api/reports/scheduled-calls",
     *     summary="Genera un informe de llamadas programadas",
     *     description="Genera un informe de llamadas programadas filtrado por zona y fecha.",
     *     tags={"Reports"},
     *     @OA\Parameter(
     *         name="zona",
     *         in="query",
     *         description="ID de la zona para el filtro.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="fecha",
     *         in="query",
     *         description="Fecha para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="operator",
     *         in="query",
     *         description="ID del operator para el filtro.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informe generado exitosamente."
     *     )
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getScheduledCalls(Request $request)
    {
        $zona_id = $request->query('zona') ?: null;
        $fecha = $request->query('fecha') ? Carbon::parse($request->query('fecha'))->startOfDay() : Carbon::parse('1800-01-01')->startOfDay();
        $operator_id = $request->query('operator') ?: null;

        $callsQuery = Call::query();

        if($fecha != '1800-01-01'){
            $callsQuery->where('fecha_hora', '>=', $fecha);
        }

        if ($zona_id) {
            $callsQuery->where('zone_id', $zona_id);
        }

        if ($operator_id) {
            $callsQuery->where('operator_id', $operator_id);
        }

        $calls = $callsQuery->get();

        $data = compact('calls');
        return $this->generatePdf('reports.scheduled_calls', $data, 'scheduled_calls_report.pdf');
    }

    /**
     * Genera un informe del historial de llamadas de un paciente por tipo.
     *
     * @OA\Get(
     *     path="/api/reports/call-history-by-patient-and-type/{patientId}",
     *     summary="Genera un informe del historial de llamadas de un paciente por tipo",
     *     description="Genera un informe del historial de llamadas de un paciente por tipo.",
     *     tags={"Reports"},
     *     @OA\Parameter(
     *         name="patientId",
     *         in="path",
     *         description="ID del paciente.",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="tipo",
     *         in="query",
     *         description="Tipo de llamada para el filtro.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informe generado exitosamente."
     *     )
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $patientId
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    public function getCallHistory(Request $request)
    {
        $patientId = $request->input('paciente_id');
        $callType = $request->input('tipo');

        $query = Call::query();

        if ($patientId) {
            $query->where('paciente_id', $patientId);
        }

        if ($callType) {
            $query->where('tipo', $callType);
        }

        $calls = $query->get();

        $data = compact('calls');
        return $this->generatePdf('reports.call_history',$data , 'call_history_by_patient_and_type_report.pdf');

    }

    /**
     * Genera un informe de llamadas realizadas.
     *
     * @OA\Get(
     *     path="/api/reports/calls-done",
     *     summary="Genera un informe de llamadas realizadas",
     *     description="Genera un informe de llamadas realizadas filtrado por fecha.",
     *     tags={"Reports"},
     *     @OA\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Fecha de inicio para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Fecha de fin para el filtro.",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="patientId",
     *         in="query",
     *         description="ID del paciente para el filtro.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informe generado exitosamente."
     *     )
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCallsDone(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();
        $patientId = $request->query('patientId') ?: null;

        $callsQuery = Call::query();
        $callsQuery = $this->applyDateFilters($callsQuery, $startDate, $endDate);
        $callsQuery->whereHas('saliente');

        if ($patientId) {
            $callsQuery->where('paciente_id', $patientId);
        }

        $calls = $callsQuery->get();

        $data = compact('calls', 'startDate', 'endDate');
        return $this->generatePdf('reports.calls_done', $data, 'calls_done_report.pdf');
    }
}