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
        'orden',
        'visible_en_landing',
        'visible_para_asesores'
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
