<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    protected $fillable = [
        'nombre',
        'url',
        'categoria',
        'descripcion'
    ];
}
