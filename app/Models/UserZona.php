<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserZona extends Model
{
    use HasFactory;

    protected $table = 'user_zonas';
    protected $fillable = ['user_id', 'zona_id'];
}