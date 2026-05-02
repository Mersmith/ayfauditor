<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TipoDocumentoEmpresaSeeder::class,
            CargoSeeder::class,
            EspecialidadSeeder::class,
            ClienteSeeder::class,
            EmpresaSeeder::class,
            PersonalSeeder::class,
            PersonalEmpresaSeeder::class,
        ]);
    }
}
