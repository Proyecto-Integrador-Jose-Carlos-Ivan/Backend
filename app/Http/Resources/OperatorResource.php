<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Operator",
 *     title="Operator",
 *     description="Operator resource",
 *     @OA\Property(property="id", type="integer", description="Operator ID"),
 *     @OA\Property(property="name", type="string", description="Operator name"),
 *     @OA\Property(property="apellidos", type="string", description="Operator surnames"),
 *     @OA\Property(property="email", type="string", description="Operator email"),
 *     @OA\Property(property="telefono", type="string", description="Operator phone"),
 *     @OA\Property(property="lenguas", type="string", description="Operator languages"),
 *     @OA\Property(property="fecha_contratacion", type="string", format="date", description="Operator hiring date"),
 *     @OA\Property(property="fecha_baja", type="string", format="date", description="Operator resignation date"),
 *     @OA\Property(property="username", type="string", description="Operator username"),
 *     @OA\Property(property="role", type="string", description="Operator role"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Operator creation date"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Operator update date")
 * )
 */
class OperatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'apellidos' => $this->apellidos,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'lenguas' => $this->lenguas,
            'fecha_contratacion' => $this->fecha_contratacion,
            'fecha_baja' => $this->fecha_baja,
            'username' => $this->username,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}