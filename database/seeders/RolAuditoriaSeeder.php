<?php

namespace Database\Seeders;

use App\Models\RolAuditoria;
use Illuminate\Database\Seeder;

class RolAuditoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['nombre' => 'Dueño / Empresario', 'slug' => 'dueno', 'descripcion' => 'Representante legal de la empresa auditada.'],
            ['nombre' => 'Colaborador Empresa', 'slug' => 'colaborador', 'descripcion' => 'Personal de la empresa que ayuda con evidencias.'],
            ['nombre' => 'Auditor Principal', 'slug' => 'auditor-principal', 'descripcion' => 'Líder del equipo de auditoría AyfAuditor.'],
            ['nombre' => 'Auditor Asistente', 'slug' => 'auditor-asistente', 'descripcion' => 'Staff de apoyo en la auditoría.'],
            ['nombre' => 'Observador', 'slug' => 'observador', 'descripcion' => 'Acceso de solo lectura para revisión.'],
        ];

        foreach ($roles as $rol) {
            RolAuditoria::create($rol);
        }
    }
}
