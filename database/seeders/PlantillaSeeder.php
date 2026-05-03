<?php

namespace Database\Seeders;

use App\Models\CategoriaPregunta;
use App\Models\Plantilla;
use App\Models\Pregunta;
use Illuminate\Database\Seeder;

class PlantillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catIT = CategoriaPregunta::where('nombre', 'like', 'IT%')->first();
        $catFin = CategoriaPregunta::where('nombre', 'like', 'Fin%')->first();

        // 1. Plantilla de IT
        $itPlantilla = Plantilla::create([
            'nombre' => 'Auditoría de Sistemas (Base)',
            'descripcion' => 'Preguntas fundamentales para revisión de infraestructura tecnológica.'
        ]);

        if ($catIT) {
            $preguntasIT = Pregunta::where('categoria_pregunta_id', $catIT->id)->get();
            foreach ($preguntasIT as $index => $pregunta) {
                $itPlantilla->preguntas()->attach($pregunta->id, ['orden' => ($index + 1) * 10]);
            }
        }

        // 2. Plantilla Financiera
        $finPlantilla = Plantilla::create([
            'nombre' => 'Control Interno Financiero',
            'descripcion' => 'Evaluación de procesos contables y tesorería.'
        ]);

        if ($catFin) {
            $preguntasFin = Pregunta::where('categoria_pregunta_id', $catFin->id)->get();
            foreach ($preguntasFin as $index => $pregunta) {
                $finPlantilla->preguntas()->attach($pregunta->id, ['orden' => ($index + 1) * 10]);
            }
        }
        
        // 3. Plantilla Full (Mezcla)
        $fullPlantilla = Plantilla::create([
            'nombre' => 'Auditoría Integral',
            'descripcion' => 'Revisión completa de todas las áreas.'
        ]);
        
        $todas = Pregunta::all();
        foreach ($todas as $index => $pregunta) {
            $fullPlantilla->preguntas()->attach($pregunta->id, ['orden' => ($index + 1) * 10]);
        }
    }
}
