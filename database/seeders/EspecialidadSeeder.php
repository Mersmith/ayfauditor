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
            ['nombre' => 'Auditoría Financiera', 'descripcion' => 'Revisión de estados financieros.'],
            ['nombre' => 'Auditoría de Sistemas', 'descripcion' => 'Evaluación de controles tecnológicos.'],
            ['nombre' => 'Gestión de Riesgos', 'descripcion' => 'Identificación y mitigación de riesgos.'],
            ['nombre' => 'Cumplimiento Normativo', 'descripcion' => 'Aseguramiento de leyes y regulaciones.'],
        ];

        foreach ($especialidades as $especialidad) {
            Especialidad::create($especialidad);
        }
    }
}
