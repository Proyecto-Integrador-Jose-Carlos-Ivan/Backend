<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ContactPersonResource",
 *     title="ContactPerson Resource",
 *     description="ContactPerson resource",
 *     @OA\Property(property="id", type="integer", format="int64", description="ContactPerson ID"),
 *     @OA\Property(property="nombre", type="string", description="ContactPerson name"),
 *     @OA\Property(property="apellido", type="string", description="ContactPerson last name"),
 *     @OA\Property(property="telefono", type="string", description="ContactPerson phone number"),
 *     @OA\Property(property="relacion", type="string", description="Relationship to patient"),
 *     @OA\Property(property="paciente_id", type="integer", format="int64", description="Patient ID"),
 * )
 */
class ContactPersonResource extends JsonResource
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
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'telefono' => $this->telefono,
            'relacion' => $this->relacion,
            'paciente_id' => $this->paciente_id,
        ];
    }
}