<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PatientResource;
use App\Http\Resources\ZoneResource;
use Illuminate\Http\Request;
use App\Models\Zone;
use App\Http\Requests\StoreZoneRequestApi;
use App\Http\Requests\UpdateZoneRequestApi;
class ZonesController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $zones = Zone::all();
            return $this->sendResponse(new ZoneResource($zones), 'Zones retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error retrieving zones.', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $zone = Zone::findOrFail($id);
            return $this->sendResponse(new ZoneResource($zone), 'Zone retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Zone not found.', null, 404);
        }
    }

    // Ejemplo para listar pacientes de una Zone
    public function patients($id)
    {
        try {
            $zone = Zone::findOrFail($id);
            // Asumiendo que Zone tiene relación 'pacientes'
            $patients = $zone->pacientes;
            return $this->sendResponse(new PatientResource($patients), 'Patients retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Zone not found.', null, 404);
        }
    }

    // Ejemplo para listar operadores asignados a una Zone
    public function operators($id)
    {
        try {
            $zone = Zone::findOrFail($id);
            // Asumiendo que Zone tiene relación 'operadores'
            $operators = $zone->users;
            return $this->sendResponse($operators, 'Operators retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Zone not found.', null, 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreZoneRequestApi $request)
    {
        try {
            $zone = Zone::create($request->all());
            return $this->sendResponse(new ZoneResource($zone), 'Zone created successfully.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error creating zone.', $e->getMessage());
        }
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateZoneRequestApi $request, string $id)
    {
        try {
            $zone = Zone::findOrFail($id);
            $zone->update($request->all());
            return $this->sendResponse(new ZoneResource($zone), 'Zone updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error updating zone.', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $zone = Zone::findOrFail($id);
            $zone->delete();
            return $this->sendResponse(null, 'Zone deleted successfully.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error deleting zone.', $e->getMessage());
        }
    }
}
