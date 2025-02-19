<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PatientResource;
use App\Http\Resources\ZoneResource;
use Illuminate\Http\Request;
use App\Models\Zone;
use App\Http\Requests\StoreZoneRequestApi;
use App\Http\Requests\UpdateZoneRequestApi;

/**
 * @OA\Tag(
 *   name="Zonas",
 *   description="Operaciones relacionadas con las zonas."
 * )
 */
class ZonesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/zones",
     *     summary="Lista todas las zonas",
     *     description="Obtiene una lista de todas las zonas disponibles.",
     *     tags={"Zonas"},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Zone")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function index(Request $request)
    {
        try {
            $zones = Zone::all();
            return $this->sendResponse($zones, 'Zonas recuperadas exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al recuperar las zonas.', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/zones/{id}",
     *     summary="Obtiene una zona por ID",
     *     description="Obtiene los detalles de una zona específica por su ID.",
     *     tags={"Zonas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la zona",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Zone")
     *     ),
     *     @OA\Response(response=404, description="Zona no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function show($id)
    {
        try {
            $zone = Zone::findOrFail($id);
            return $this->sendResponse($zone, 'Zona recuperada exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Zona no encontrada.', null, 404);
        }
    }

    /**
     * List patients in a zone.
     *
     * @OA\Get(
     *     path="/api/zones/{id}/patients",
     *     summary="Lista los pacientes en una zona",
     *     description="Obtiene una lista de los pacientes asociados a una zona específica.",
     *     tags={"Zonas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la zona",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Patient")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Zona no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function patients($id)
    {
        try {
            $zone = Zone::findOrFail($id);
            // Asumiendo que Zone tiene relación 'pacientes'
            $patients = $zone->pacientes;
            return $this->sendResponse($patients, 'Pacientes recuperados exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Zona no encontrada.', null, 404);
        }
    }

    /**
     * List operators assigned to a zone.
     *
     * @OA\Get(
     *     path="/api/zones/{id}/operators",
     *     summary="Lista los operadores asignados a una zona",
     *     description="Obtiene una lista de los operadores (usuarios) asignados a una zona específica.",
     *     tags={"Zonas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la zona",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Zona no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function operators($id)
    {
        try {
            $zone = Zone::findOrFail($id);
            // Asumiendo que Zone tiene relación 'operadores'
            $operators = $zone->users;
            return $this->sendResponse($operators, 'Operadores recuperados exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Zona no encontrada.', null, 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/zones",
     *     summary="Crea una nueva zona",
     *     description="Crea una nueva zona con la información proporcionada.",
     *     tags={"Zonas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreZoneRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Zone")
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function store(StoreZoneRequestApi $request)
    {
        try {
            $zone = Zone::create($request->all());
            return $this->sendResponse($zone, 'Zona creada exitosamente.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error al crear la zona.', $e->getMessage());
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/zones/{id}",
     *     summary="Actualiza una zona por ID",
     *     description="Actualiza la información de una zona específica por su ID.",
     *     tags={"Zonas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la zona",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateZoneRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Zone")
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=404, description="Zona no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function update(UpdateZoneRequestApi $request, string $id)
    {
        try {
            $zone = Zone::findOrFail($id);
            $zone->update($request->all());
            return $this->sendResponse($zone, 'Zona actualizada exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al actualizar la zona.', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/zones/{id}",
     *     summary="Elimina una zona por ID",
     *     description="Elimina una zona específica por su ID.",
     *     tags={"Zonas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la zona",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Operación exitosa (sin contenido)"
     *     ),
     *     @OA\Response(response=404, description="Zona no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function destroy(string $id)
    {
        try {
            $zone = Zone::findOrFail($id);
            $zone->delete();
            return $this->sendResponse(null, 'Zona eliminada exitosamente.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error al eliminar la zona.', $e->getMessage());
        }
    }
}