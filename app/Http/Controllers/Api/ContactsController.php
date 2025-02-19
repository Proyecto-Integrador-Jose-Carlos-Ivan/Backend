<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ContactPersonResource;
use Illuminate\Http\Request;
use App\Models\ContactPerson as Contact;
use App\Http\Requests\StoreContactRequestApi;
use App\Http\Requests\UpdateContactRequestApi;

/**
 * @OA\Tag(
 *   name="Contactos",
 *   description="Operaciones relacionadas con los contactos de un paciente."
 * )
 */
class ContactsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/patients/{patientId}/contacts",
     *     summary="Lista todos los contactos de un paciente",
     *     description="Obtiene una lista de todos los contactos asociados a un paciente específico.",
     *     tags={"Contactos"},
     *     @OA\Parameter(
     *         name="patientId",
     *         in="path",
     *         description="ID del paciente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ContactPerson")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function index(Request $request, $patientId)
    {
        try {
            $contacts = Contact::where('paciente_id', $patientId)->get();
            return $this->sendResponse($contacts, 'Contactos recuperados exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al recuperar los contactos.', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/patients/{patientId}/contacts",
     *     summary="Crea un nuevo contacto para un paciente",
     *     description="Crea un nuevo contacto asociado a un paciente específico.",
     *     tags={"Contactos"},
     *     @OA\Parameter(
     *         name="patientId",
     *         in="path",
     *         description="ID del paciente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreContactRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/ContactPerson")
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function store(StoreContactRequestApi $request, $patientId)
    {
        try {
            $data = $request->all();
            $data['paciente_id'] = $patientId;
            $contact = Contact::create($data);
            return $this->sendResponse($contact, 'Contacto creado exitosamente.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error al crear el contacto.', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/contacts/{id}",
     *     summary="Actualiza un contacto por ID",
     *     description="Actualiza la información de un contacto específico por su ID.",
     *     tags={"Contactos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del contacto",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateContactRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/ContactPerson")
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=404, description="Contacto no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function update(UpdateContactRequestApi $request, $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->update($request->all());
            return $this->sendResponse($contact, 'Contacto actualizado exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al actualizar el contacto.', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/contacts/{id}",
     *     summary="Elimina un contacto por ID",
     *     description="Elimina un contacto específico por su ID.",
     *     tags={"Contactos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del contacto",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Operación exitosa (sin contenido)"
     *     ),
     *     @OA\Response(response=404, description="Contacto no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            return $this->sendResponse(null, 'Contacto eliminado exitosamente.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error al eliminar el contacto.', $e->getMessage());
        }
    }
}