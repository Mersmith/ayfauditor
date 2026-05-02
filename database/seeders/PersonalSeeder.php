<?php

namespace Database\Seeders;

use App\Models\Personal;
use Illuminate\Database\Seeder;

class PersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Personal::create([
            'nombre' => 'Carlos Contador',
            'dni' => '11223344',
            'celular' => '900111222',
            'activo' => true,
        ]);

        Personal::create([
            'nombre' => 'Ana Administradora',
            'dni' => '55667788',
            'celular' => '900555666',
            'activo' => true,
        ]);

        Personal::create([
            'nombre' => 'Luis Logística',
            'dni' => '99001122',
            'celular' => '900999000',
            'activo' => true,
        ]);
    }
}
