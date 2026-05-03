<?php

namespace Database\Seeders;

use App\Models\Auditoria;
use App\Models\Empresa;
use App\Models\EstadoAuditoria;
use App\Models\EstadoRespuesta;
use App\Models\Plantilla;
use App\Models\Respuesta;
use Illuminate\Database\Seeder;

class AuditoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresa1 = Empresa::first();
        $empresa2 = Empresa::skip(1)->first();

        $plantillaIT = Plantilla::where('nombre', 'like', '%Sistemas%')->first();
        $plantillaFin = Plantilla::where('nombre', 'like', '%Financiero%')->first();

        $estadoProgreso = EstadoAuditoria::where('nombre', 'like', '%Progreso%')->first() ?? EstadoAuditoria::first();
        $estadoRespuestaPendiente = EstadoRespuesta::where('nombre', 'like', '%Pendiente%')->first() ?? EstadoRespuesta::first();

        // 1. Auditoría IT para Empresa 1
        if ($empresa1 && $plantillaIT) {
            $auditoria = Auditoria::create([
                'empresa_id' => $empresa1->id,
                'plantilla_id' => $plantillaIT->id,
                'titulo' => 'Auditoría Anual IT - '.$empresa1->razon_social,
                'estado_auditoria_id' => $estadoProgreso->id,
                'fecha_inicio' => now()->format('Y-m-d'),
                'fecha_fin' => now()->addMonths(2)->format('Y-m-d'),
            ]);

            foreach ($plantillaIT->preguntas as $pregunta) {
                Respuesta::create([
                    'auditoria_id' => $auditoria->id,
                    'pregunta_id' => $pregunta->id,
                    'estado_respuesta_id' => $estadoRespuestaPendiente->id,
                ]);
            }
        }

        // 2. Auditoría Financiera para Empresa 2
        if ($empresa2 && $plantillaFin) {
            $auditoria = Auditoria::create([
                'empresa_id' => $empresa2->id,
                'plantilla_id' => $plantillaFin->id,
                'titulo' => 'Revisión Fiscal Trimestral - '.$empresa2->razon_social,
                'estado_auditoria_id' => $estadoProgreso->id,
                'fecha_inicio' => now()->format('Y-m-d'),
                'fecha_fin' => now()->addMonth()->format('Y-m-d'),
            ]);

            foreach ($plantillaFin->preguntas as $pregunta) {
                Respuesta::create([
                    'auditoria_id' => $auditoria->id,
                    'pregunta_id' => $pregunta->id,
                    'estado_respuesta_id' => $estadoRespuestaPendiente->id,
                ]);
            }
        }
    }
}
