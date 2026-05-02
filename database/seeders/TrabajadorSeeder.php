<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Especialidad;
use App\Models\Trabajador;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TrabajadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargoAuditor = Cargo::where('nombre', 'like', '%Auditor%')->first();
        $espFinanciera = Especialidad::where('nombre', 'like', '%Financiera%')->first();
        $espSistemas = Especialidad::where('nombre', 'like', '%Sistemas%')->first();

        // Trabajador 1: Auditor Financiero
        $user1 = User::create([
            'name' => 'Roberto Auditor',
            'email' => 'roberto@ayfauditor.com',
            'password' => Hash::make('password'),
            'activo' => true,
        ]);

        Trabajador::create([
            'user_id' => $user1->id,
            'nombre' => 'Roberto Auditor',
            'dni' => '12121212',
            'especialidad_id' => $espFinanciera?->id,
            'cargo_id' => $cargoAuditor?->id,
            'registro_profesional' => 'CPC-99988',
            'activo' => true,
        ]);

        // Trabajador 2: Auditor IT
        $user2 = User::create([
            'name' => 'Lucía Sistemas',
            'email' => 'lucia@ayfauditor.com',
            'password' => Hash::make('password'),
            'activo' => true,
        ]);

        Trabajador::create([
            'user_id' => $user2->id,
            'nombre' => 'Lucía Sistemas',
            'dni' => '34343434',
            'especialidad_id' => $espSistemas?->id,
            'cargo_id' => $cargoAuditor?->id,
            'registro_profesional' => 'CISA-4455',
            'activo' => true,
        ]);
    }
}
