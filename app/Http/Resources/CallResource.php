<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CallResource",
 *     title="Call Resource",
 *     description="Call resource",
 *     @OA\Property(property="id", type="integer", format="int64", description="Call ID"),
 *     @OA\Property(property="fecha_hora", type="string", format="date-time", description="Call date and time"),
 *     @OA\Property(property="operador_id", type="integer", format="int64", description="Operator ID"),
 *     @OA\Property(property="paciente_id", type="integer", format="int64", description="Patient ID"),
 *     @OA\Property(property="descripcion", type="string", description="Call description"),
 *     @OA\Property(property="sentido", type="string", description="Call direction"),
 *     @OA\Property(property="categoria", type="string", description="Call category"),
 *     @OA\Property(property="subtipo", type="string", description="Call subtype"),
 *     @OA\Property(property="aviso_id", type="integer", format="int64", description="Alert ID"),
 *     @OA\Property(property="operador", ref="#/components/schemas/UserResource", description="Operator details"),
 *     @OA\Property(property="paciente", ref="#/components/schemas/PatientResource", description="Patient details"),
 *     @OA\Property(property="aviso", ref="#/components/schemas/AlertResource", description="Alert details"),
 * )
 */
class CallResource extends JsonResource
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
            'fecha_hora' => $this->fecha_hora,
            'operador_id' => $this->operador_id,
            'paciente_id' => $this->paciente_id,
            'descripcion' => $this->descripcion,
            'sentido' => $this->sentido,
            'categoria' => $this->categoria,
            'subtipo' => $this->subtipo,
            'aviso_id' => $this->aviso_id,
            'paciente' => $this->paciente,
            'aviso' => $this->aviso,
        ];
    }
}