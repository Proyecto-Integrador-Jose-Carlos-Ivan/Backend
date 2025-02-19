<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *   name="Operadores",
 *   description="Operaciones relacionadas con los operadores (usuarios)."
 * )
 */
class OperatorsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/operators",
     *     summary="Lista todos los operadores",
     *     description="Obtiene una lista de todos los operadores (usuarios) disponibles.",
     *     tags={"Operadores"},
     *      security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function index(Request $request)
    {
        try {
            $operators = User::all();
            return $this->sendResponse($operators, 'Operadores recuperados exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al recuperar los operadores.', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/operators",
     *     summary="Crea un nuevo operador",
     *     description="Crea un nuevo operador (usuario) con la información proporcionada.",
     *     tags={"Operadores"},
     *      security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error de validación.', $validator->errors(), 422);
        }

        try {
            $operator = User::create($request->all());
            return $this->sendResponse($operator, 'Operador creado exitosamente.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error al crear el operador.', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/operators/{id}",
     *     summary="Obtiene un operador por ID",
     *     description="Obtiene los detalles de un operador (usuario) específico por su ID.",
     *     tags={"Operadores"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del operador",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=404, description="Operador no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function show($id)
    {
        try {
            $operator = User::findOrFail($id);
            return $this->sendResponse($operator, 'Operador recuperado exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Operador no encontrado.', null, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/operators/{id}",
     *     summary="Actualiza un operador por ID",
     *     description="Actualiza la información de un operador (usuario) específico por su ID.",
     *     tags={"Operadores"},
     *    security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del operador",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=404, description="Operador no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $operator = User::findOrFail($id);

             $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
                'email' => 'string|email|max:255|unique:users,email,'.$id,
                'password' => 'string|min:6',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Error de validación.', $validator->errors(), 422);
            }

            $operator->update($request->all());
            return $this->sendResponse($operator, 'Operador actualizado exitosamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al actualizar el operador.', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/operators/{id}",
     *     summary="Elimina un operador por ID",
     *     description="Elimina un operador (usuario) específico por su ID.",
     *     tags={"Operadores"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del operador",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Operación exitosa (sin contenido)"
     *     ),
     *     @OA\Response(response=404, description="Operador no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function destroy($id)
    {
        try {
            $operator = User::findOrFail($id);
            $operator->delete();
            return $this->sendResponse(null, 'Operador eliminado exitosamente.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error al eliminar el operador.', $e->getMessage());
        }
    }
}