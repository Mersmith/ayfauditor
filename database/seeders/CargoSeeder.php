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
            ['nombre' => 'Gerente General', 'color' => '#1e293b', 'icono' => 'fa-solid fa-user-tie'],
            ['nombre' => 'Administrador', 'color' => '#334155', 'icono' => 'fa-solid fa-user-gear'],
            ['nombre' => 'Contador', 'color' => '#0f172a', 'icono' => 'fa-solid fa-calculator'],
            ['nombre' => 'Auditor Senior', 'color' => '#2563eb', 'icono' => 'fa-solid fa-user-shield'],
            ['nombre' => 'Auditor Junior', 'color' => '#3b82f6', 'icono' => 'fa-solid fa-user-check'],
            ['nombre' => 'Asistente Administrativo', 'color' => '#475569', 'icono' => 'fa-solid fa-user-pen'],
        ];

        foreach ($cargos as $cargo) {
            Cargo::updateOrCreate(
                ['nombre' => $cargo['nombre']],
                [
                    'color' => $cargo['color'],
                    'icono' => $cargo['icono'],
                    'activo' => true,
                ]
            );
        }
    }
}
