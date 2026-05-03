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
            ['nombre' => 'IT / Tecnología', 'descripcion' => 'Infraestructura, seguridad y sistemas.'],
            ['nombre' => 'Financiera / Contable', 'descripcion' => 'Estados financieros y tesorería.'],
            ['nombre' => 'Legal / Normativa', 'descripcion' => 'Leyes, actas y cumplimiento.'],
            ['nombre' => 'Recursos Humanos', 'descripcion' => 'Gestión de personal y planilla.'],
        ];

        foreach ($categorias as $cat) {
            CategoriaPregunta::create($cat);
        }
    }
}
