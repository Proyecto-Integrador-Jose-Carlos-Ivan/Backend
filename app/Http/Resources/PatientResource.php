<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PatientResource",
 *     title="Patient Resource",
 *     description="Patient resource",
 *     @OA\Property(property="id", type="integer", format="int64", description="Patient ID"),
 *     @OA\Property(property="nombre", type="string", description="Patient name"),
 *     @OA\Property(property="fecha_nacimiento", type="string", format="date", description="Patient birth date"),
 *     @OA\Property(property="direccion", type="string", description="Patient address"),
 *     @OA\Property(property="dni", type="string", description="Patient DNI"),
 *     @OA\Property(property="sip", type="string", description="Patient SIP"),
 *     @OA\Property(property="telefono", type="string", description="Patient phone number"),
 *     @OA\Property(property="email", type="string", format="email", description="Patient email"),
 *     @OA\Property(property="zona_id", type="integer", format="int64", description="Zone ID"),
 *     @OA\Property(property="contacto_id", type="integer", format="int64", description="Contact ID"),
 *     @OA\Property(property="situacion_personal", type="string", description="Patient personal situation"),
 *     @OA\Property(property="situacion_sanitaria", type="string", description="Patient health situation"),
 *     @OA\Property(property="situacion_habitage", type="string", description="Patient housing situation"),
 *     @OA\Property(property="autonomia", type="string", description="Patient autonomy level"),
 *     @OA\Property(property="situacion_economica", type="string", description="Patient economic situation"),
 * )
 */
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