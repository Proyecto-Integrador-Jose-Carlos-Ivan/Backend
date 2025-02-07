<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    protected $table = 'zonas';

    protected $fillable = [
        'name',
    ];

    public function pacientes()
    {
        return $this->hasMany(Patient::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_zonas');
    }
}
