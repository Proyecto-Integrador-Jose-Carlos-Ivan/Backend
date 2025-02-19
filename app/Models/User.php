<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User model",
 *     @OA\Property(property="id", type="integer", format="int64", description="User ID"),
 *     @OA\Property(property="name", type="string", description="User name"),
 *     @OA\Property(property="email", type="string", format="email", description="User email"),
 *     @OA\Property(property="telefono", type="string", description="User phone number"),
 *     @OA\Property(property="lenguas", type="string", description="Languages spoken by the user"),
 *     @OA\Property(property="fecha_contratacion", type="string", format="date", description="User hire date"),
 *     @OA\Property(property="fecha_baja", type="string", format="date", description="User termination date"),
 *     @OA\Property(property="username", type="string", description="User username"),
 *     @OA\Property(property="apellidos", type="string", description="User last names"),
 *     @OA\Property(property="role", type="string", description="User role"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp")
 * )
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'telefono',
        'lenguas',
        'fecha_contratacion',
        'fecha_baja',
        'username',
        'apellidos',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function zonas()
    {
        return $this->belongsToMany(Zone::class, 'user_zonas');
    }

    public function llamadas()
    {
        return $this->hasMany(Call::class, 'operador_id');
    }
}
