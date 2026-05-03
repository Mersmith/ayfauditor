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
            ['nombre' => 'Sin Iniciar', 'slug' => 'vacio', 'color' => 'gray', 'descripcion' => 'Aún no se ha cargado información.'],
            ['nombre' => 'Enviado / Por Revisar', 'slug' => 'enviado', 'color' => 'blue', 'descripcion' => 'El cliente ya respondió, pendiente revisión del auditor.'],
            ['nombre' => 'En Revisión', 'slug' => 'en_revision', 'color' => 'indigo', 'descripcion' => 'El auditor está validando la respuesta.'],
            ['nombre' => 'Observado', 'slug' => 'observado', 'color' => 'orange', 'descripcion' => 'Se requiere corregir o añadir más información.'],
            ['nombre' => 'Aprobado', 'slug' => 'aprobado', 'color' => 'green', 'descripcion' => 'La respuesta y evidencia han sido validadas.'],
        ];

        foreach ($estados as $est) {
            EstadoRespuesta::create($est);
        }
    }
}
