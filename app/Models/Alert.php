<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Alert",
 *     title="Alert",
 *     description="Alert model",
 *     @OA\Property(property="id", type="integer", format="int64", description="Alert ID"),
 *     @OA\Property(property="message", type="string", description="Alert message"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp")
 * )
 */
class Alert extends Model
{
    use HasFactory;

    protected $table = 'avisos';

    protected $fillable = [
        'recurrencia',
        'tipo',
        'subtipo',
        'fecha',
        'dia_semana',
        'descripcion',
        'operador_id',
        'paciente_id',
        'zona_id',
    ];

    public function llamadas()
    {
        return $this->hasMany(Call::class, 'aviso_id');
    }
}
