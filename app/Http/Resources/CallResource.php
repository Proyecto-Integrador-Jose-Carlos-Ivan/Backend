<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'operador' => $this->operador,
            'paciente' => $this->paciente,
            'aviso' => $this->aviso,
        ];
    }
}
