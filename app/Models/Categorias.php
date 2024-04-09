<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reparaciones;

class Categorias extends Model
{
    use HasFactory;
    protected $fillable = ['categoria_rep'];
    public function reparaciones()
{
    return $this->hasMany(Reparaciones::class, 'categorias_id');
}
}
