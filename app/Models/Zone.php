<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Zone",
 *     title="Zone",
 *     description="Zone model",
 *     @OA\Property(property="id", type="integer", format="int64", description="Zone ID"),
 *     @OA\Property(property="name", type="string", description="Zone name"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp")
 * )
 */
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
