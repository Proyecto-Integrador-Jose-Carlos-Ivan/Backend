<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'direccion' => $this->direccion,
            'dni' => $this->dni,
            'sip' => $this->sip,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'zona_id' => $this->zona_id,
            'contacto_id' => $this->contacto_id,
            'situacion_personal' => $this->situacion_personal,
            'situacion_sanitaria' => $this->situacion_sanitaria,
            'situacion_habitage' => $this->situacion_habitage,
            'autonomia' => $this->autonomia,
            'situacion_economica' => $this->situacion_economica,
        ];
    }
}
