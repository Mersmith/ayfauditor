<?php

namespace Database\Seeders;

use App\Models\EstadoAuditoria;
use Illuminate\Database\Seeder;

class EstadoAuditoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nombre' => 'Pendiente', 'color' => 'gray', 'descripcion' => 'Auditoría creada pero aún no iniciada.'],
            ['nombre' => 'En Proceso', 'color' => 'blue', 'descripcion' => 'Auditoría con actividades en curso.'],
            ['nombre' => 'Finalizada', 'color' => 'green', 'descripcion' => 'Auditoría completada satisfactoriamente.'],
            ['nombre' => 'Cancelada', 'color' => 'red', 'descripcion' => 'Auditoría anulada por el administrador.'],
        ];

        foreach ($estados as $est) {
            EstadoAuditoria::create($est);
        }
    }
}
