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
        $servicios = [
            [
                'nombre_servicio' => 'Foto para hoja de vida profesional',
                'valor' => 15500,
                'porcentaje_comision' => 30,
            ],
            [
                'nombre_servicio' => 'Hoja de vida sencilla',
                'valor' => 7500,
                'porcentaje_comision' => 30,
            ],
            [
                'nombre_servicio' => 'Hoja de vida profesional',
                'valor' => 15000,
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
                'nombre_servicio' => 'Paquete completo',
                'valor' => 20000,
                'porcentaje_comision' => 30,
            ],
        ];

        foreach ($servicios as $servicio) {
            Servicio::updateOrCreate(
                ['nombre_servicio' => $servicio['nombre_servicio']],
                $servicio
            );
        }
    }
}
