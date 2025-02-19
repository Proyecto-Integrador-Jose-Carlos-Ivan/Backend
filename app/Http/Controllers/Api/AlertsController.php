<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreAlertRequestApi;
use App\Http\Requests\UpdateAlertRequestApi;
use App\Http\Resources\AlertResource;
use Illuminate\Http\Request;
use App\Models\Alert;

/**
 * @OA\Tag(
 *   name="Alertas",
 *   description="Operaciones relacionadas con las alertas."
 * )
 */
class AlertsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/alerts",
     *     summary="Lista todas las alertas",
     *     description="Obtiene una lista de todas las alertas disponibles.",
     *     tags={"Alertas"},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Alert")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function index(Request $request)
    {
        try {
            $alerts = Alert::all();
            return $this->sendResponse($alerts, 'Alertas recuperadas exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al recuperar las alertas.', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/alerts",
     *     summary="Crea una nueva alerta",
     *     description="Crea una nueva alerta con la información proporcionada.",
     *     tags={"Alertas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreAlertRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Alert")
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function store(StoreAlertRequestApi $request)
    {
        try {
            $alert = Alert::create($request->validated());
            return $this->sendResponse($alert, 'Alerta creada exitosamente.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error al crear la alerta.', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/alerts/{id}",
     *     summary="Obtiene una alerta por ID",
     *     description="Obtiene los detalles de una alerta específica por su ID.",
     *     tags={"Alertas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la alerta",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Alert")
     *     ),
     *     @OA\Response(response=404, description="Alerta no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function show($id)
    {
        try {
            $alert = Alert::findOrFail($id);
            return $this->sendResponse($alert, 'Alerta recuperada exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Alerta no encontrada.', null, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/alerts/{id}",
     *     summary="Actualiza una alerta por ID",
     *     description="Actualiza la información de una alerta específica por su ID.",
     *     tags={"Alertas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la alerta",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateAlertRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Alert")
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=404, description="Alerta no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function update(UpdateAlertRequestApi $request, $id)
    {
        try {
            $alert = Alert::findOrFail($id);
            $alert->update($request->validated());
            return $this->sendResponse($alert, 'Alerta actualizada exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al actualizar la alerta.', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/alerts/{id}",
     *     summary="Elimina una alerta por ID",
     *     description="Elimina una alerta específica por su ID.",
     *     tags={"Alertas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la alerta",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Operación exitosa (sin contenido)"
     *     ),
     *     @OA\Response(response=404, description="Alerta no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function destroy($id)
    {
        try {
            $alert = Alert::findOrFail($id);
            $alert->delete();
            return $this->sendResponse(null, 'Alerta eliminada exitosamente.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error al eliminar la alerta.', $e->getMessage());
        }
    }
}