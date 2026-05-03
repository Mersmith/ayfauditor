<?php

namespace Database\Seeders;

use App\Models\Especialidad;
use Illuminate\Database\Seeder;

class EspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especialidades = [
            ['nombre' => 'Auditoría Financiera', 'descripcion' => 'Revisión de estados financieros.', 'color' => '#3b82f6', 'icono' => 'fa-solid fa-file-invoice-dollar'],
            ['nombre' => 'Auditoría de Sistemas', 'descripcion' => 'Evaluación de controles tecnológicos.', 'color' => '#10b981', 'icono' => 'fa-solid fa-server'],
            ['nombre' => 'Gestión de Riesgos', 'descripcion' => 'Identificación y mitigación de riesgos.', 'color' => '#ef4444', 'icono' => 'fa-solid fa-shield-halved'],
            ['nombre' => 'Cumplimiento Normativo', 'descripcion' => 'Aseguramiento de leyes y regulaciones.', 'color' => '#f59e0b', 'icono' => 'fa-solid fa-scale-balanced'],
        ];

        foreach ($especialidades as $especialidad) {
            Especialidad::create($especialidad);
        }
    }
}
