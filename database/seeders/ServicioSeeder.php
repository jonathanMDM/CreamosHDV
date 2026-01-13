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
                'nombre' => 'Foto para hoja de vida profesional',
                'descripcion' => 'Retoque digital y optimización para hojas de vida y plataformas como LinkedIn. Sirve para plataformas de empleo también.',
                'precio' => 15500,
                'activo' => true,
            ],
            [
                'nombre' => 'Hoja de vida sencilla',
                'descripcion' => 'Formato básico, ideal para perfiles operativos y administrativos. Diseño limpio y profesional.',
                'precio' => 7500,
                'activo' => true,
            ],
            [
                'nombre' => 'Hoja de vida profesional',
                'descripcion' => 'Diseño premium con impacto visual garantizado. Estructuras modernas para destacar en procesos de selección.',
                'precio' => 15000,
                'activo' => true,
            ],
            [
                'nombre' => 'Traducción de hoja de vida',
                'descripcion' => 'Traducción profesional Inglés-Español adaptada a términos laborales técnicos.',
                'precio' => 25000,
                'activo' => true,
            ],
            [
                'nombre' => 'Carta de presentación',
                'descripcion' => 'El complemento perfecto para explicar por qué eres el candidato ideal.',
                'precio' => 6000,
                'activo' => true,
            ],
            [
                'nombre' => 'Paquete completo',
                'descripcion' => 'Incluye: Hoja de vida profesional, carta de presentación, foto profesional y traducción. La solución definitiva para tu perfil.',
                'precio' => 20000,
                'activo' => true,
            ],
        ];

        foreach ($servicios as $servicio) {
            Servicio::updateOrCreate(
                ['nombre' => $servicio['nombre']],
                $servicio
            );
        }
    }
}
