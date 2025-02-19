<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Patient",
 *     title="Patient",
 *     description="Patient model",
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
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp")
 * )
 */
class Patient extends Model
{
    use HasFactory;
    protected $table = 'pacientes';


    protected $fillable = [
        'nombre',
        'fecha_nacimiento',
        'direccion',
        'dni',
        'sip',
        'telefono',
        'email',
        'zona_id',
        'contacto_id',
        'situacion_personal',
        'situacion_sanitaria',
        'situacion_habitage',
        'autonomia',
        'situacion_economica',
    ];

    public function zona()
    {
        return $this->belongsTo(Zone::class);
    }

    public function contacto()
    {
        return $this->belongsTo(ContactPerson::class, 'contacto_id');
    }

    public function contactos()
    {
        return $this->hasMany(ContactPerson::class);
    }

    public function llamadas()
    {
        return $this->hasMany(Call::class);
    }
}
