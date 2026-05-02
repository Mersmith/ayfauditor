<?php

namespace App\Livewire\Erp\Cliente;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Cliente')]
class ClienteEditar extends Component
{
    public Cliente $cliente;
    public User $user;

    // Propiedades para el formulario
    public string $name = '';
    public string $email = '';
    public string $password = ''; // Opcional en edición
    public string $nombre = '';
    public string $dni = '';
    public string $celular = '';

    public function mount($id)
    {
        $this->cliente = Cliente::with('user')->findOrFail($id);
        $this->user = $this->cliente->user;

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->nombre = $this->cliente->nombre;
        $this->dni = $this->cliente->dni ?? '';
        $this->celular = $this->cliente->celular ?? '';
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'nombre' => ['required', 'string', 'max:255'],
            'dni' => ['nullable', 'string', 'max:20', Rule::unique('clientes', 'dni')->ignore($this->cliente->id)->whereNull('deleted_at')],
            'celular' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function update(): void
    {
        $this->validate();

        DB::transaction(function () {
            $userData = [
                'name' => $this->name,
                'email' => $this->email,
            ];

            if ($this->password) {
                $userData['password'] = Hash::make($this->password);
            }

            $this->user->update($userData);

            $this->cliente->update([
                'nombre' => $this->nombre,
                'dni' => $this->dni,
                'celular' => $this->celular,
            ]);
        });

        session()->flash('success', 'Cliente actualizado correctamente.');
        $this->redirect(route('erp.cliente.vista.lista'), navigate: true);
    }

    public function delete(): void
    {
        // El softdelete solo afecta al perfil del cliente en este caso, 
        // o podrías eliminar también el usuario si lo deseas.
        $this->cliente->delete();

        session()->flash('success', 'Cliente eliminado (Soft Delete) correctamente.');
        $this->redirect(route('erp.cliente.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.cliente.cliente-editar');
    }
}
