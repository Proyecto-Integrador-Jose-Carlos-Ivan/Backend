<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'google_id' => $this->google_id,
            'avatar' => $this->avatar,
            'telefono' => $this->telefono,
            'lenguas' => $this->lenguas,
            'fecha_contratacion' => $this->fecha_contratacion,
            'fecha_baja' => $this->fecha_baja,
            'username' => $this->username,
            'apellidos' => $this->apellidos,
            'role' => $this->role,
        ];
    }
}
