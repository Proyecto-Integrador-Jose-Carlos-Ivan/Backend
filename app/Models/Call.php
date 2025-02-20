<?php

namespace App\Models;

use App\Events\CallCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Call",
 *     title="Call",
 *     description="Call model",
 *     @OA\Property(property="id", type="integer", format="int64", description="Call ID"),
 *     @OA\Property(property="fecha_hora", type="string", format="date-time", description="Call date and time"),
 *     @OA\Property(property="operador_id", type="integer", format="int64", description="Operator ID"),
 *     @OA\Property(property="paciente_id", type="integer", format="int64", description="Patient ID"),
 *     @OA\Property(property="descripcion", type="string", description="Call description"),
 *     @OA\Property(property="sentido", type="string", description="Call direction"),
 *     @OA\Property(property="categoria", type="string", description="Call category"),
 *     @OA\Property(property="subtipo", type="string", description="Call subtype"),
 *     @OA\Property(property="aviso_id", type="integer", format="int64", description="Alert ID"),
 *     @OA\Property(property="zone_id", type="integer", format="int64", description="Zone ID"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp")
 * )
 */
class Call extends Model
{
    use HasFactory;
    protected $table = 'llamadas';

    protected $fillable = [
        'fecha_hora',
        'operador_id',
        'paciente_id',
        'descripcion',
        'sentido',
        'categoria',
        'subtipo',
        'aviso_id',
        'zone_id',
    ];

    public function operador()
    {
        return $this->belongsTo(User::class, 'operador_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Patient::class);
    }

    public function aviso()
    {
        return $this->belongsTo(Alert::class, 'aviso_id');
    }

    public function zona()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    protected static function booted()
    {
        static::created(function ($call) {
            event(new CallCreated($call));
        });
    
        static::updated(function ($call) {
            event(new CallCreated($call));
        });
    }

}