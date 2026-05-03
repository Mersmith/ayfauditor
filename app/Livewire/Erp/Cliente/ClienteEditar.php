<?php

namespace App\Livewire\Erp\Cliente;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Editar Cliente')]
class ClienteEditar extends Component
{
    public Cliente $cliente;

    public User $user;

    public $name;

    public $email;

    public $nombre;

    public $dni;

    public $celular;

    public $activo;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user->id)],
            'nombre' => 'required|string|max:255',
            'dni' => ['nullable', 'string', 'max:20', Rule::unique('clientes', 'dni')->ignore($this->cliente->id)->whereNull('deleted_at')],
            'celular' => 'nullable|string|max:20',
            'activo' => 'boolean',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'name' => 'usuario login',
            'email' => 'correo electrónico',
            'nombre' => 'nombre completo',
            'dni' => 'DNI/RUC',
            'celular' => 'celular',
            'activo' => 'estado',
        ];
    }

    public function mount($id)
    {
        $this->cliente = Cliente::with('user')->findOrFail($id);
        $this->user = $this->cliente->user;

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->activo = (bool) $this->cliente->activo;

        $this->nombre = $this->cliente->nombre;
        $this->dni = $this->cliente->dni ?? '';
        $this->celular = $this->cliente->celular ?? '';
    }

    public function update()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Datos Inválidos',
                'text' => 'Verifique los campos resaltados.',
            ]);
            throw $e;
        }

        try {
            DB::beginTransaction();

            $this->user->update([
                'name' => trim($this->name),
                'email' => strtolower(trim($this->email)),
                'activo' => $this->activo,
            ]);

            $this->cliente->update([
                'nombre' => trim($this->nombre),
                'dni' => trim($this->dni),
                'celular' => trim($this->celular),
                'activo' => $this->activo,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Actualizado!',
                'text' => 'Los datos del cliente se han actualizado correctamente.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-cliente')->error('[CLIENTE] Error al actualizar cliente: ' . $e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->cliente->id,
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo actualizar el cliente.',
            ]);
        }
    }

    public function enviarRecuperarClave()
    {
        try {
            $this->validateOnly('email');
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'El correo electrónico es inválido.',
            ]);
            throw $e;
        }

        Password::sendResetLink(['email' => $this->email]);

        $this->dispatch('alertaLivewire', [
            'type' => 'success',
            'title' => 'Correo Enviado',
            'text' => 'Se ha enviado un enlace para restablecer la contraseña a ' . $this->email,
        ]);
    }

    #[On('eliminarClienteOn')]
    public function eliminarClienteOn()
    {
        try {
            DB::beginTransaction();
            $this->cliente->delete();
            // Opcionalmente eliminar el usuario si no tiene otros perfiles
            // $this->user->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminado',
                'text' => 'El cliente ha sido eliminado correctamente.',
            ]);

            return redirect()->route('erp.cliente.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-cliente')->error('[CLIENTE] Error al eliminar cliente: ' . $e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->cliente->id,
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo eliminar el cliente.',
            ]);
        }
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }

    public function render()
    {
        return view('livewire.erp.cliente.cliente-editar');
    }
}
