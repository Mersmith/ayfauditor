<?php

namespace Database\Seeders;

use App\Models\Auditoria;
use App\Models\EstadoRespuesta;
use App\Models\Respuesta;
use App\Models\User;
use Illuminate\Database\Seeder;

class RespuestaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auditoria = Auditoria::first();
        $estadoCumple = EstadoRespuesta::where('nombre', 'Cumple')->first();
        $adminUser = User::where('email', 'admin@ayfauditor.com')->first();

        if ($auditoria && $estadoCumple) {
            // Actualizar un par de respuestas para simular avance
            $respuestas = Respuesta::where('auditoria_id', $auditoria->id)->limit(2)->get();

            foreach ($respuestas as $index => $resp) {
                $resp->update([
                    'respuesta_cliente' => 'Evidencia verificada. Se adjuntó el documento de política de seguridad v2.0.',
                    'estado_respuesta_id' => $estadoCumple->id,
                    'fecha_inicio' => now()->subDays(5)->format('Y-m-d'),
                    'fecha_fin' => now()->format('Y-m-d'),
                    'updated_by' => $adminUser?->id,
                ]);

                // Agregar un comentario interno
                $resp->comentarios()->create([
                    'user_id' => $adminUser?->id,
                    'mensaje' => 'La política está completa pero falta la firma del gerente de IT.',
                    'leido' => true,
                ]);
            }
        }
    }
}
