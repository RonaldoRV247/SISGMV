<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reparaciones;

class Detalles_Mantenimiento extends Model
{
    use HasFactory;
    protected $table = 'detalles_mantenimiento';
    protected $fillable = ['id','descripcion','costo','mantenimientos_id','reparaciones_id'];

    public function reparacion()
    {
        return $this->belongsTo(Reparaciones::class, 'reparaciones_id');
    }
    public function mantenimiento()
    {
        return $this->belongsTo(Mantenimientos::class, 'mantenimientos_id');
    }

}
