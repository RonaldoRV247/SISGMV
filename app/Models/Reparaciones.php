<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorias;

class Reparaciones extends Model
{
    use HasFactory;
    protected $fillable = ['elemento','categorias_id'];
    public function categorias()
    {
        return $this->belongsTo(Categorias::class, 'categorias_id');
    }
}
