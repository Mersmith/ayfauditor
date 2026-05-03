<?php

namespace Database\Seeders;

use App\Models\CategoriaPregunta;
use App\Models\Pregunta;
use Illuminate\Database\Seeder;

class PreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catIT = CategoriaPregunta::where('nombre', 'like', 'IT%')->first();
        $catFin = CategoriaPregunta::where('nombre', 'like', 'Fin%')->first();
        $catLegal = CategoriaPregunta::where('nombre', 'like', 'Legal%')->first();

        $preguntas = [
            // IT
            [
                'texto' => '¿Cuenta la empresa con una política de copias de seguridad documentada?',
                'categoria_pregunta_id' => $catIT?->id,
                'descripcion_ayuda' => 'Verificar la frecuencia, medio de almacenamiento y pruebas de restauración.',
                'orden_sugerido' => 10
            ],
            [
                'texto' => '¿Se realiza control de acceso físico al centro de datos o servidores?',
                'categoria_pregunta_id' => $catIT?->id,
                'descripcion_ayuda' => 'Revisar bitácoras de ingreso y sistemas de seguridad (llaves, biométricos).',
                'orden_sugerido' => 20
            ],
            // Financiera
            [
                'texto' => '¿Existe segregación de funciones en el proceso de pagos?',
                'categoria_pregunta_id' => $catFin?->id,
                'descripcion_ayuda' => 'Quien registra la factura no debe ser quien aprueba el pago.',
                'orden_sugerido' => 10
            ],
            [
                'texto' => '¿Se realizan conciliaciones bancarias mensualmente?',
                'categoria_pregunta_id' => $catFin?->id,
                'descripcion_ayuda' => 'Verificar firmas de revisión y partidas pendientes de larga data.',
                'orden_sugerido' => 20
            ],
            // Legal
            [
                'texto' => '¿Están vigentes todos los libros de actas de la junta directiva?',
                'categoria_pregunta_id' => $catLegal?->id,
                'descripcion_ayuda' => 'Validar legalización y firmas de la última sesión.',
                'orden_sugerido' => 10
            ],
        ];

        foreach ($preguntas as $p) {
            Pregunta::create($p);
        }
    }
}
