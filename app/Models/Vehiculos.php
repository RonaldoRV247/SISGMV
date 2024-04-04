<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Personas;
use App\Models\Mantenimientos;

class Vehiculos extends Model
{
    use HasFactory;
    protected $fillable = ['placa','unidad','marca','modelo','motor','anio','km','carga_util_kg','personas_id'];
    public function personas()
    {
        return $this->belongsTo(Personas::class, 'personas_id');
    }
    public function mantenimientos()
    {
        return $this->hasMany(Mantenimientos::class, 'vehiculos_id');
    }
}
