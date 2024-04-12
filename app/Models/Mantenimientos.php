<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Detalles_Mantenimiento;
use App\Models\Vehiculos;
use App\Models\Proveedores;

class Mantenimientos extends Model
{
    use HasFactory;
    protected $table = 'mantenimientos';
    protected $fillable = [ 'tipo','expediente','fecha_requerimiento','fecha_conformidad_servicio','fecha_ingreso_taller','fecha_salida_taller','km_mantenimiento','vehiculos_id','proveedores_id'];
    public function detallesMantenimiento()
    {
        return $this->hasMany(Detalles_Mantenimiento::class, 'mantenimientos_id');
    }
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id');
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedores::class, 'proveedores_id');
    }

}
