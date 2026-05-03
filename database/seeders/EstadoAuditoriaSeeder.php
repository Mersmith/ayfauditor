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
            ['nombre' => 'Pendiente', 'color' => '#6b7280', 'icono' => 'fa-solid fa-clock', 'descripcion' => 'Auditoría creada pero aún no iniciada.'],
            ['nombre' => 'En Proceso', 'color' => '#3b82f6', 'icono' => 'fa-solid fa-spinner fa-spin', 'descripcion' => 'Auditoría con actividades en curso.'],
            ['nombre' => 'Finalizada', 'color' => '#10b981', 'icono' => 'fa-solid fa-circle-check', 'descripcion' => 'Auditoría completada satisfactoriamente.'],
            ['nombre' => 'Cancelada', 'color' => '#ef4444', 'icono' => 'fa-solid fa-circle-xmark', 'descripcion' => 'Auditoría anulada por el administrador.'],
        ];

        foreach ($estados as $est) {
            EstadoAuditoria::create($est);
        }
    }
}
