<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PatientResource;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Http\Requests\StorePatientRequestApi;
use App\Http\Requests\UpdatePatientRequestApi;


class PatientsController extends BaseController
{
    public function index(Request $request)
    {
        try {
            // Listar Patients, opcionalmente filtrados por zona
            $patients = Patient::all();
            return $this->sendResponse($patients, 'Patients retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error retrieving patients.', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $patient = Patient::create($request->all());
            return $this->sendResponse($patient, 'Patient created successfully.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error creating patient.', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            return $this->sendResponse($patient, 'Patient retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Patient not found.', null, 404);
        }
    }

    public function update(UpdatePatientRequestApi $request, $id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->update($request->all());
            return $this->sendResponse($patient, 'Patient updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error updating patient.', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();
            return $this->sendResponse(null, 'Patient deleted successfully.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error deleting patient.', $e->getMessage());
        }
    }
}
