<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
