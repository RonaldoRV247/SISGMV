<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehiculos;

class Personas extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','apellidos','celular'];
    public function vehiculos()
{
    return $this->hasMany(Vehiculos::class, 'personas_id');
}
}
