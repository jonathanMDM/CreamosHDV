<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servicio;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Servicio::truncate();

        $servicios = [
            [
                'nombre_servicio' => 'Foto Profesional',
                'valor' => 15000,
                'porcentaje_comision' => 30,
            ],
            [
                'nombre_servicio' => 'Hoja Diseño Básico',
                'valor' => 7500,
                'porcentaje_comision' => 30,
            ],
            [
                'nombre_servicio' => 'Hoja Diseño Premium',
                'valor' => 15500,
                'porcentaje_comision' => 30,
            ],
            [
                'nombre_servicio' => 'Traducción de hoja de vida',
                'valor' => 25000,
                'porcentaje_comision' => 30,
            ],
            [
                'nombre_servicio' => 'Carta de presentación',
                'valor' => 6000,
                'porcentaje_comision' => 30,
            ],
            [
                'nombre_servicio' => 'Paquete Completo',
                'valor' => 20000,
                'porcentaje_comision' => 30,
            ],
        ];

        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }
    }
}
