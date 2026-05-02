<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cliente 1
        $user1 = User::create([
            'name' => 'Juan Perez - Cliente',
            'email' => 'juan@cliente.com',
            'password' => Hash::make('password'),
            'activo' => true,
        ]);

        Cliente::create([
            'user_id' => $user1->id,
            'nombre' => 'Grupo Perez S.A.',
            'dni' => '10203040',
            'celular' => '999888777',
            'activo' => true,
        ]);

        // Cliente 2
        $user2 = User::create([
            'name' => 'Maria Lopez - Cliente',
            'email' => 'maria@cliente.com',
            'password' => Hash::make('password'),
            'activo' => true,
        ]);

        Cliente::create([
            'user_id' => $user2->id,
            'nombre' => 'Inversiones Lopez E.I.R.L.',
            'dni' => '50607080',
            'celular' => '999111222',
            'activo' => true,
        ]);
    }
}
