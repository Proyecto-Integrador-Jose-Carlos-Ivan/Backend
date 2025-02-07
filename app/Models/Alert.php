<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
