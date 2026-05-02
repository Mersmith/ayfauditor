<?php

namespace Database\Seeders;

use App\Models\Cargo;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargos = [
            ['nombre' => 'Gerente General', 'descripcion' => 'Máxima autoridad ejecutiva.'],
            ['nombre' => 'Contador General', 'descripcion' => 'Responsable de la contabilidad.'],
            ['nombre' => 'Auditor Interno', 'descripcion' => 'Encargado de controles internos.'],
            ['nombre' => 'Jefe de IT', 'descripcion' => 'Responsable de sistemas y tecnología.'],
            ['nombre' => 'Asesor Legal', 'descripcion' => 'Consultor jurídico externo/interno.'],
        ];

        foreach ($cargos as $cargo) {
            Cargo::create($cargo);
        }
    }
}
