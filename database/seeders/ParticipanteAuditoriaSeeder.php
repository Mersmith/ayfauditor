<?php

namespace Database\Seeders;

use App\Models\Auditoria;
use App\Models\Cargo;
use App\Models\ParticipanteAuditoria;
use App\Models\User;
use Illuminate\Database\Seeder;

class ParticipanteAuditoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auditoriaIT = Auditoria::where('titulo', 'like', '%IT%')->first();
        $auditoriaFin = Auditoria::where('titulo', 'like', '%Fiscal%')->first();

        // Roles de Auditoria (Cargos unificados)
        $cargoDueno = Cargo::where('slug', 'dueno')->first();
        $cargoColaborador = Cargo::where('slug', 'colaborador')->first();
        $cargoAuditorPrincipal = Cargo::where('slug', 'auditor-principal')->first();
        $cargoAuditorAsistente = Cargo::where('slug', 'auditor-asistente')->first();

        // Usuarios disponibles
        $userAdmin = User::where('email', 'admin@ayfauditor.com')->first();
        $userRoberto = User::where('email', 'roberto@ayfauditor.com')->first();
        $userLucia = User::where('email', 'lucia@ayfauditor.com')->first();

        // Usuarios Clientes (asumiendo que existen por ClienteSeeder)
        $userCliente = User::whereHas('cliente')->first();
        // Usuarios Personal (asumiendo que existen por PersonalSeeder)
        $userPersonal = User::whereHas('personal')->first();

        // 1. Participantes para Auditoría IT
        if ($auditoriaIT) {
            // Auditor Principal (Lucía es la de IT)
            if ($userLucia && $cargoAuditorPrincipal) {
                ParticipanteAuditoria::create([
                    'auditoria_id' => $auditoriaIT->id,
                    'user_id' => $userLucia->id,
                    'cargo_id' => $cargoAuditorPrincipal->id,
                    'invitado_por' => $userAdmin?->id,
                ]);
            }

            // El dueño de la empresa (Cliente)
            if ($userCliente && $cargoDueno) {
                ParticipanteAuditoria::create([
                    'auditoria_id' => $auditoriaIT->id,
                    'user_id' => $userCliente->id,
                    'cargo_id' => $cargoDueno->id,
                    'invitado_por' => $userLucia?->id,
                ]);
            }

            // Un colaborador externo (Personal)
            if ($userPersonal && $cargoColaborador) {
                ParticipanteAuditoria::create([
                    'auditoria_id' => $auditoriaIT->id,
                    'user_id' => $userPersonal->id,
                    'cargo_id' => $cargoColaborador->id,
                    'invitado_por' => $userLucia?->id,
                ]);
            }
        }

        // 2. Participantes para Auditoría Financiera
        if ($auditoriaFin) {
            // Auditor Principal (Roberto es el financiero)
            if ($userRoberto && $cargoAuditorPrincipal) {
                ParticipanteAuditoria::create([
                    'auditoria_id' => $auditoriaFin->id,
                    'user_id' => $userRoberto->id,
                    'cargo_id' => $cargoAuditorPrincipal->id,
                    'invitado_por' => $userAdmin?->id,
                ]);
            }

            // El dueño (mismo cliente para el ejemplo)
            if ($userCliente && $cargoDueno) {
                ParticipanteAuditoria::create([
                    'auditoria_id' => $auditoriaFin->id,
                    'user_id' => $userCliente->id,
                    'cargo_id' => $cargoDueno->id,
                    'invitado_por' => $userRoberto?->id,
                ]);
            }
        }
    }
}
