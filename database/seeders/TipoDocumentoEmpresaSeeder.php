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
            ['nombre' => 'Registro Único de Contribuyentes', 'abreviatura' => 'RUC', 'color' => 'blue', 'icono' => 'fa-solid fa-file-invoice-dollar'],
            ['nombre' => 'Número de Identificación Tributaria', 'abreviatura' => 'NIT', 'color' => 'green', 'icono' => 'fa-solid fa-building-columns'],
            ['nombre' => 'Registro Federal de Contribuyentes', 'abreviatura' => 'RFC', 'color' => 'orange', 'icono' => 'fa-solid fa-address-card'],
            ['nombre' => 'Cédula de Identidad Jurídica', 'abreviatura' => 'CIJ', 'color' => 'purple', 'icono' => 'fa-solid fa-scale-balanced'],
        ];

        foreach ($tipos as $tipo) {
            TipoDocumentoEmpresa::create($tipo);
        }
    }
}
