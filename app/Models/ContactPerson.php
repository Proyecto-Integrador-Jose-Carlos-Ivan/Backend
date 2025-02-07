<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
