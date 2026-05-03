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
            // Administrativos
            ['nombre' => 'Gerente General', 'descripcion' => 'Máxima autoridad ejecutiva.', 'color' => 'red', 'icono' => 'fa-solid fa-user-tie', 'tipo' => 'administrativo'],
            ['nombre' => 'Contador General', 'descripcion' => 'Responsable de la contabilidad.', 'color' => 'blue', 'icono' => 'fa-solid fa-calculator', 'tipo' => 'administrativo'],
            ['nombre' => 'Auditor Interno', 'descripcion' => 'Encargado de controles internos.', 'color' => 'green', 'icono' => 'fa-solid fa-user-check', 'tipo' => 'administrativo'],
            ['nombre' => 'Jefe de IT', 'descripcion' => 'Responsable de sistemas y tecnología.', 'color' => 'purple', 'icono' => 'fa-solid fa-laptop-code', 'tipo' => 'administrativo'],
            ['nombre' => 'Asesor Legal', 'descripcion' => 'Consultor jurídico externo/interno.', 'color' => 'orange', 'icono' => 'fa-solid fa-gavel', 'tipo' => 'administrativo'],

            // Especiales para Auditoría
            ['nombre' => 'Dueño / Empresario', 'slug' => 'dueno', 'color' => '#1d4ed8', 'icono' => 'fa-solid fa-user-tie', 'descripcion' => 'Representante legal de la empresa auditada.', 'tipo' => 'auditoria'],
            ['nombre' => 'Colaborador Empresa', 'slug' => 'colaborador', 'color' => '#059669', 'icono' => 'fa-solid fa-user-gear', 'descripcion' => 'Personal de la empresa que ayuda con evidencias.', 'tipo' => 'auditoria'],
            ['nombre' => 'Auditor Principal', 'slug' => 'auditor-principal', 'color' => '#dc2626', 'icono' => 'fa-solid fa-user-check', 'descripcion' => 'Líder del equipo de auditoría AyfAuditor.', 'tipo' => 'auditoria'],
            ['nombre' => 'Auditor Asistente', 'slug' => 'auditor-asistente', 'color' => '#ea580c', 'icono' => 'fa-solid fa-user-pen', 'descripcion' => 'Staff de apoyo en la auditoría.', 'tipo' => 'auditoria'],
            ['nombre' => 'Observador', 'slug' => 'observador', 'color' => '#4b5563', 'icono' => 'fa-solid fa-user-secret', 'descripcion' => 'Acceso de solo lectura para revisión.', 'tipo' => 'auditoria'],
        ];

        foreach ($cargos as $cargo) {
            Cargo::create($cargo);
        }
    }
}
