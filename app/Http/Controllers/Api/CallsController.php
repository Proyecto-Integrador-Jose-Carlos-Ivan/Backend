<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CallResource;
use App\Events\CallCreated;
use Illuminate\Http\Request;
use App\Models\Call;
use App\Http\Requests\StoreCallRequestApi;
use App\Http\Requests\UpdateCallRequestApi;

/**
 * @OA\Tag(
 *   name="Llamadas",
 *   description="Operaciones relacionadas con las llamadas."
 * )
 */
class CallsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/calls",
     *     summary="Lista todas las llamadas",
     *     description="Obtiene una lista de todas las llamadas disponibles.",
     *     tags={"Llamadas"},
     *      security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Call")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function index(Request $request)
    {
        return CallResource::collection(Call::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/calls",
     *     summary="Crea una nueva llamada",
     *     description="Crea una nueva llamada con la información proporcionada.",
     *     tags={"Llamadas"},
     *      security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCallRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Call")
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function store(StoreCallRequestApi $request)
    {
        try {
            $call = Call::create($request->validated());
            event(new CallCreated($call));

            return $this->sendResponse($call, 'Llamada creada exitosamente.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error al crear la llamada.', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/calls/{id}",
     *     summary="Obtiene una llamada por ID",
     *     description="Obtiene los detalles de una llamada específica por su ID.",
     *     tags={"Llamadas"},
     *      security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la llamada",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Call")
     *     ),
     *     @OA\Response(response=404, description="Llamada no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function show($id)
    {
        try {
            $call = Call::findOrFail($id);
            return $this->sendResponse($call, 'Llamada recuperada exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Llamada no encontrada.', null, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/calls/{id}",
     *     summary="Actualiza una llamada por ID",
     *     description="Actualiza la información de una llamada específica por su ID.",
     *     tags={"Llamadas"},
     *      security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la llamada",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCallRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Call")
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=404, description="Llamada no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function update(UpdateCallRequestApi $request, $id)
    {
        try {
            $call = Call::findOrFail($id);
            $call->update($request->validated());

            event(new CallCreated($call));

            return $this->sendResponse($call, 'Llamada actualizada exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al actualizar la llamada.', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/calls/{id}",
     *     summary="Elimina una llamada por ID",
     *     description="Elimina una llamada específica por su ID.",
     *     tags={"Llamadas"},
     *      security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la llamada",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Operación exitosa (sin contenido)"
     *     ),
     *     @OA\Response(response=404, description="Llamada no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function destroy($id)
    {
        try {
            $call = Call::findOrFail($id);
            $call->delete();
            event(new CallCreated($call));

            return $this->sendResponse(null, 'Llamada eliminada exitosamente.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error al eliminar la llamada.', $e->getMessage());
        }
    }

    /**
     * Show the calls view.
     *
     * @OA\Get(
     *     path="/calls",
     *     summary="Muestra la vista de llamadas",
     *     description="Muestra la vista de llamadas.",
     *     tags={"Llamadas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\MediaType(
     *             mediaType="text/html"
     *         )
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function calls()
    {
        return view('calls.calls');
    }
}