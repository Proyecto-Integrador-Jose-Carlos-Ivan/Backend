<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
