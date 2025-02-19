<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="ContactPerson",
 *     title="ContactPerson",
 *     description="ContactPerson model",
 *     @OA\Property(property="id", type="integer", format="int64", description="ContactPerson ID"),
 *     @OA\Property(property="nombre", type="string", description="ContactPerson name"),
 *     @OA\Property(property="apellido", type="string", description="ContactPerson last name"),
 *     @OA\Property(property="telefono", type="string", description="ContactPerson phone number"),
 *     @OA\Property(property="relacion", type="string", description="Relationship to patient"),
 *      @OA\Property(property="paciente_id", type="integer", format="int64", description="Patient ID"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp")
 * )
 */
class ContactPerson extends Model
{
    use HasFactory;
    protected $table = 'contactos';


    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'relacion',
        'paciente_id',
    ];

    public function paciente()
    {
        return $this->belongsTo(Patient::class);
    }
}
