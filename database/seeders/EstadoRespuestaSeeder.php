<?php

namespace Database\Seeders;

use App\Models\EstadoRespuesta;
use Illuminate\Database\Seeder;

class EstadoRespuestaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            [
                'nombre' => 'Pendiente',
                'descripcion' => 'La pregunta aún no ha sido respondida.',
                'color' => '#6b7280',
                'icono' => 'fa-solid fa-clock',
                'activo' => true,
            ],
            [
                'nombre' => 'Cumple',
                'descripcion' => 'La evidencia confirma el cumplimiento.',
                'color' => '#10b981',
                'icono' => 'fa-solid fa-check-circle',
                'activo' => true,
            ],
            [
                'nombre' => 'No Cumple',
                'descripcion' => 'No se encontró evidencia de cumplimiento.',
                'color' => '#ef4444',
                'icono' => 'fa-solid fa-times-circle',
                'activo' => true,
            ],
            [
                'nombre' => 'Cumple Parcialmente',
                'descripcion' => 'Cumplimiento incompleto o en proceso.',
                'color' => '#f59e0b',
                'icono' => 'fa-solid fa-adjust',
                'activo' => true,
            ],
            [
                'nombre' => 'No Aplica',
                'descripcion' => 'El control no es aplicable a esta entidad.',
                'color' => '#3b82f6',
                'icono' => 'fa-solid fa-minus-circle',
                'activo' => true,
            ],
        ];

        foreach ($estados as $estado) {
            EstadoRespuesta::create($estado);
        }
    }
}
