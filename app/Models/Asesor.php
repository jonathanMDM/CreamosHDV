<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    protected $fillable = [
        'nombre_completo',
        'cedula',
        'email',
        'banco',
        'banco_nombre_otro',
        'numero_cuenta',
        'whatsapp',
        'ciudad',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
