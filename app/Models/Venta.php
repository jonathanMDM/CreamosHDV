<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'asesor_id',
        'servicio_id',
        'nombre_cliente',
        'telefono_cliente',
        'valor_servicio',
        'comision',
        'image_url',
        'tipo_pago',
        'estado',
        'motivo_rechazo',
        'es_venta_directa'
    ];

    public function asesor()
    {
        return $this->belongsTo(Asesor::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
