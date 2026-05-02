<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\Personal;
use App\Models\PersonalEmpresa;
use Illuminate\Database\Seeder;

class PersonalEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresa = Empresa::first();
        $personal1 = Personal::where('nombre', 'like', 'Carlos%')->first();
        $personal2 = Personal::where('nombre', 'like', 'Ana%')->first();
        $cargoContador = Cargo::where('nombre', 'like', 'Contador%')->first();
        $cargoGerente = Cargo::where('nombre', 'like', 'Gerente%')->first();

        if ($empresa && $personal1 && $cargoContador) {
            PersonalEmpresa::create([
                'empresa_id' => $empresa->id,
                'personal_id' => $personal1->id,
                'cargo_id' => $cargoContador->id,
                'activo' => true,
            ]);
        }

        if ($empresa && $personal2 && $cargoGerente) {
            PersonalEmpresa::create([
                'empresa_id' => $empresa->id,
                'personal_id' => $personal2->id,
                'cargo_id' => $cargoGerente->id,
                'activo' => true,
            ]);
        }
    }
}
