<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'asesor_id',
        'servicio_id',
        'valor_servicio',
        'comision',
        'image_url',
        'estado',
        'motivo_rechazo'
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
