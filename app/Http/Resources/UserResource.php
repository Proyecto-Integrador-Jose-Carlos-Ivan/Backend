<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="UserResource",
 *     title="User Resource",
 *     description="User resource",
 *     @OA\Property(property="id", type="integer", format="int64", description="User ID"),
 *     @OA\Property(property="name", type="string", description="User name"),
 *     @OA\Property(property="email", type="string", description="User email"),
 *     @OA\Property(property="google_id", type="string", nullable=true, description="Google ID"),
 *     @OA\Property(property="avatar", type="string", nullable=true, description="User avatar URL"),
 *     @OA\Property(property="telefono", type="string", nullable=true, description="User phone number"),
 *     @OA\Property(property="lenguas", type="string", nullable=true, description="Languages spoken by the user"),
 *     @OA\Property(property="fecha_contratacion", type="string", format="date", nullable=true, description="User hire date"),
 *     @OA\Property(property="fecha_baja", type="string", format="date", nullable=true, description="User termination date"),
 *     @OA\Property(property="username", type="string", description="User username"),
 *     @OA\Property(property="apellidos", type="string", description="User last names"),
 *     @OA\Property(property="role", type="string", description="User role"),
 * )
 */
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