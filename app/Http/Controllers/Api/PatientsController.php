<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Http\Requests\StorePatientRequestApi;
use App\Http\Requests\UpdatePatientRequestApi;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *   name="Pacientes",
 *   description="Operaciones relacionadas con los pacientes."
 * )
 */
class PatientsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/patients",
     *     summary="Lista todos los pacientes",
     *     description="Obtiene una lista de todos los pacientes disponibles.",
     *     tags={"Pacientes"},
     *      security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Patient")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor")
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function index()
    {
        try {
            // Listar Patients, opcionalmente filtrados por zona
            $patients = Patient::all();
            return $this->sendResponse(PatientResource::collection($patients), 'Pacientes recuperados exitosamente.');
        }catch (\Exception $e) {
            return $this->sendError('Error al recuperar los pacientes.', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/patients",
     *     summary="Crea un nuevo paciente",
     *     description="Crea un nuevo paciente con la información proporcionada.",
     *     tags={"Pacientes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StorePatientRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function store(Request $request)
    {
        try {
            $patient = Patient::create($request->all());
            return $this->sendResponse(new PatientResource($patient), 'Paciente creado exitosamente.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error al crear el paciente.', $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/patients/{id}",
     *     summary="Obtiene un paciente por ID",
     *     description="Obtiene los detalles de un paciente específico por su ID.",
     *     tags={"Pacientes"},
     *    security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del paciente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(response=404, description="Paciente no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function show($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            return $this->sendResponse(new PatientResource($patient), 'Paciente recuperado exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Paciente no encontrado.', null, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/patients/{id}",
     *     summary="Actualiza un paciente por ID",
     *     description="Actualiza la información de un paciente específico por su ID.",
     *     tags={"Pacientes"},
     *    security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del paciente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdatePatientRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=404, description="Paciente no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->update($request->all());
            return $this->sendResponse(new PatientResource($patient), 'Paciente actualizado exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al actualizar el paciente.', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/patients/{id}",
     *     summary="Elimina un paciente por ID",
     *     description="Elimina un paciente específico por su ID.",
     *     tags={"Pacientes"},
     *   security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del paciente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Operación exitosa (sin contenido)"
     *     ),
     *     @OA\Response(response=404, description="Paciente no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();
            return $this->sendResponse(null, 'Paciente eliminado exitosamente.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error al eliminar el paciente.', $e->getMessage());
        }
    }
}