<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'nombre_servicio',
        'descripcion',
        'icono',
        'valor',
        'porcentaje_comision',
        'orden'
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
