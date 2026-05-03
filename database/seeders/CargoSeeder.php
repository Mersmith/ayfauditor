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
            ['nombre' => 'Gerente General', 'descripcion' => 'Máxima autoridad ejecutiva.', 'color' => 'red', 'icono' => 'fa-solid fa-user-tie'],
            ['nombre' => 'Contador General', 'descripcion' => 'Responsable de la contabilidad.', 'color' => 'blue', 'icono' => 'fa-solid fa-calculator'],
            ['nombre' => 'Auditor Interno', 'descripcion' => 'Encargado de controles internos.', 'color' => 'green', 'icono' => 'fa-solid fa-user-check'],
            ['nombre' => 'Jefe de IT', 'descripcion' => 'Responsable de sistemas y tecnología.', 'color' => 'purple', 'icono' => 'fa-solid fa-laptop-code'],
            ['nombre' => 'Asesor Legal', 'descripcion' => 'Consultor jurídico externo/interno.', 'color' => 'orange', 'icono' => 'fa-solid fa-gavel'],
        ];

        foreach ($cargos as $cargo) {
            Cargo::create($cargo);
        }
    }
}
