<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\TipoDocumentoEmpresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cliente1 = Cliente::first();
        $tipoRuc = TipoDocumentoEmpresa::where('abreviatura', 'RUC')->first();

        if ($cliente1 && $tipoRuc) {
            Empresa::create([
                'cliente_id' => $cliente1->id,
                'tipo_documento_empresa_id' => $tipoRuc->id,
                'razon_social' => 'Perez Construcciones S.A.C.',
                'nombre_comercial' => 'Perez Construe',
                'numero_documento' => '20123456789',
                'direccion_fiscal' => 'Av. Siempre Viva 123',
                'activo' => true,
            ]);

            Empresa::create([
                'cliente_id' => $cliente1->id,
                'tipo_documento_empresa_id' => $tipoRuc->id,
                'razon_social' => 'Perez Transportes S.A.',
                'nombre_comercial' => 'Perez Trans',
                'numero_documento' => '20987654321',
                'direccion_fiscal' => 'Calle Falsa 456',
                'activo' => true,
            ]);
        }
    }
}
