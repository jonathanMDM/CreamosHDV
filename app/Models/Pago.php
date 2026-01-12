<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'asesor_id',
        'tipo',
        'semana',
        'mes',
        'año',
        'fecha_inicio_semana',
        'fecha_fin_semana',
        'total_comisiones',
        'bonificacion',
        'total_pagar',
        'cantidad_ventas',
        'pagado',
        'fecha_pago'
    ];

    protected $casts = [
        'pagado' => 'boolean',
        'fecha_pago' => 'datetime',
        'fecha_inicio_semana' => 'date',
        'fecha_fin_semana' => 'date',
    ];

    public function asesor()
    {
        return $this->belongsTo(Asesor::class);
    }
}
