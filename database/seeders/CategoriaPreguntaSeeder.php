<?php

namespace Database\Seeders;

use App\Models\CategoriaPregunta;
use Illuminate\Database\Seeder;

class CategoriaPreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'IT / Tecnología', 'descripcion' => 'Infraestructura, seguridad y sistemas.', 'color' => '#3b82f6', 'icono' => 'fa-solid fa-microchip'],
            ['nombre' => 'Financiera / Contable', 'descripcion' => 'Estados financieros y tesorería.', 'color' => '#10b981', 'icono' => 'fa-solid fa-coins'],
            ['nombre' => 'Legal / Normativa', 'descripcion' => 'Leyes, actas y cumplimiento.', 'color' => '#ef4444', 'icono' => 'fa-solid fa-gavel'],
            ['nombre' => 'Recursos Humanos', 'descripcion' => 'Gestión de personal y planilla.', 'color' => '#f59e0b', 'icono' => 'fa-solid fa-users-gear'],
        ];

        foreach ($categorias as $cat) {
            CategoriaPregunta::create($cat);
        }
    }
}
