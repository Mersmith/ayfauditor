<?php

namespace Database\Seeders;

use App\Models\TipoDocumentoEmpresa;
use Illuminate\Database\Seeder;

class TipoDocumentoEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Registro Único de Contribuyentes', 'abreviatura' => 'RUC'],
            ['nombre' => 'Número de Identificación Tributaria', 'abreviatura' => 'NIT'],
            ['nombre' => 'Registro Federal de Contribuyentes', 'abreviatura' => 'RFC'],
            ['nombre' => 'Cédula de Identidad Jurídica', 'abreviatura' => 'CIJ'],
        ];

        foreach ($tipos as $tipo) {
            TipoDocumentoEmpresa::create($tipo);
        }
    }
}
