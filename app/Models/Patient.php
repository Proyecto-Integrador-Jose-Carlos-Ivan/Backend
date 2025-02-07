<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
