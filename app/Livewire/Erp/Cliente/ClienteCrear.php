<?php

namespace App\Livewire\Erp\Cliente;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Crear Cliente')]
class ClienteCrear extends Component
{
    public $name;

    public $email;

    public $password;

    public $nombre;

    public $dni;

    public $celular;

    public $activo = true;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nombre' => 'required|string|max:255',
            'dni' => 'nullable|string|max:20|unique:clientes,dni',
            'celular' => 'nullable|string|max:20',
            'activo' => 'required|boolean',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'name' => 'usuario login',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'nombre' => 'nombre completo',
            'dni' => 'DNI/RUC',
            'celular' => 'celular',
            'activo' => 'estado',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Datos Incompletos',
                'text' => 'Por favor, revise los campos marcados en rojo.',
            ]);
            throw $e;
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => trim($this->name),
                'email' => strtolower(trim($this->email)),
                'password' => Hash::make($this->password),
                'activo' => $this->activo,
            ]);

            // Crear el registro de cliente asociado
            Cliente::create([
                'user_id' => $user->id,
                'nombre' => trim($this->nombre),
                'dni' => trim($this->dni),
                'celular' => trim($this->celular),
                'activo' => $this->activo,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => 'El cliente ha sido creado correctamente.',
            ]);

            return redirect()->route('erp.cliente.vista.lista');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-cliente')->error('[CLIENTE] Error al crear cliente: ' . $e->getMessage(), [
                'usuario_id' => auth()->id(),
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo crear el cliente. Se ha registrado el incidente.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.cliente.cliente-crear');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
