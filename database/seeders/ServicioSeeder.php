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
                'descripcion' => 'Retoque digital y optimización para hojas de vida y plataformas como LinkedIn.',
                'icono' => 'fas fa-camera',
                'valor' => 15000,
                'porcentaje_comision' => 30,
            ],
            [
                'nombre_servicio' => 'Hoja Diseño Básico',
                'descripcion' => 'Hoja de vida sencilla y limpia, ideal para perfiles operativos y administrativos.',
                'icono' => 'fas fa-file-lines',
                'valor' => 7500,
                'porcentaje_comision' => 30,
            ],
            [
                'nombre_servicio' => 'Hoja Diseño Premium',
                'descripcion' => 'Impacto visual garantizado con diseños modernos y estructurados para resaltar.',
                'icono' => 'fas fa-crown',
                'valor' => 15500,
                'porcentaje_comision' => 30,
            ],
            [
                'nombre_servicio' => 'Traducción de hoja de vida',
                'descripcion' => 'Traducción profesional (Inglés-Español) adaptada a términos laborales técnicos.',
                'icono' => 'fas fa-language',
                'valor' => 25000,
                'porcentaje_comision' => 30,
            ],
            [
                'nombre_servicio' => 'Carta de presentación',
                'descripcion' => 'El complemento perfecto para explicar por qué eres el candidato ideal.',
                'icono' => 'fas fa-envelope-open-text',
                'valor' => 6000,
                'porcentaje_comision' => 30,
            ],
            [
                'nombre_servicio' => 'Paquete Completo',
                'descripcion' => 'Hoja de vida premium + Carta de presentación + Formato editable',
                'icono' => 'fas fa-box-open',
                'valor' => 20000,
                'porcentaje_comision' => 30,
            ],
        ];

        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }
    }
}
