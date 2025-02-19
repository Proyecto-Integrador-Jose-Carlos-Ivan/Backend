<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="AlertResource",
 *     title="Alert Resource",
 *     description="Alert resource",
 *     @OA\Property(property="id", type="integer", format="int64", description="Alert ID"),
 *     @OA\Property(property="recurrencia", type="string", description="Alert recurrence"),
 *     @OA\Property(property="tipo", type="string", description="Alert type"),
 *     @OA\Property(property="subtipo", type="string", description="Alert subtype"),
 *     @OA\Property(property="fecha", type="string", format="date", description="Alert date"),
 *     @OA\Property(property="dia_semana", type="string", description="Day of the week"),
 *     @OA\Property(property="descripcion", type="string", description="Alert description"),
 *     @OA\Property(property="operador_id", type="integer", format="int64", description="Operator ID"),
 *     @OA\Property(property="paciente_id", type="integer", format="int64", description="Patient ID"),
 *     @OA\Property(property="zona_id", type="integer", format="int64", description="Zone ID"),
 * )
 */
class AlertResource extends JsonResource
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
            'recurrencia' => $this->recurrencia,
            'tipo' => $this->tipo,
            'subtipo' => $this->subtipo,
            'fecha' => $this->fecha,
            'dia_semana' => $this->dia_semana,
            'descripcion' => $this->descripcion,
            'operador_id' => $this->operador_id,
            'paciente_id' => $this->paciente_id,
            'zona_id' => $this->zona_id,
        ];
    }
}