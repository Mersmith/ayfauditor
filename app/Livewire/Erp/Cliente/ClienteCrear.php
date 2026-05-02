<?php

namespace App\Livewire\Erp\Cliente;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Crear Cliente')]
class ClienteCrear extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $nombre = '';
    public string $dni = '';
    public string $celular = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'nombre' => ['required', 'string', 'max:255'],
            'dni' => ['nullable', 'string', 'max:20', 'unique:clientes,dni'],
            'celular' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        DB::transaction(function () {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            $user->cliente()->create([
                'nombre' => $this->nombre,
                'dni' => $this->dni,
                'celular' => $this->celular,
            ]);

            // Asignar rol si es necesario (ej: cliente)
            // $user->assignRole('cliente');
        });

        session()->flash('success', 'Cliente creado correctamente.');

        $this->redirect(route('erp.cliente.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.cliente.cliente-crear');
    }
}
