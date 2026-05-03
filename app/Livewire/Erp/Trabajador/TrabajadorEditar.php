<?php

namespace App\Livewire\Erp\Trabajador;

use App\Models\Cargo;
use App\Models\Especialidad;
use App\Models\Trabajador;
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
#[Title('Editar Trabajador')]
class TrabajadorEditar extends Component
{
    public Trabajador $trabajador;

    public User $user;

    // Datos Personales
    public $nombre;

    public $dni;

    public $activo;

    // Datos de Acceso
    public $name;

    public $email;

    // Perfil Profesional
    public $especialidad_id;

    public $cargo_id;

    public $registro_profesional;

    public function mount($id)
    {
        $this->trabajador = Trabajador::with('user')->findOrFail($id);
        $this->user = $this->trabajador->user;

        $this->nombre = $this->trabajador->nombre;
        $this->dni = $this->trabajador->dni ?? '';
        $this->activo = (bool) $this->trabajador->activo;

        $this->name = $this->user->name;
        $this->email = $this->user->email;

        $this->especialidad_id = $this->trabajador->especialidad_id;
        $this->cargo_id = $this->trabajador->cargo_id;
        $this->registro_profesional = $this->trabajador->registro_profesional ?? '';
    }

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'dni' => ['nullable', 'string', 'max:20', Rule::unique('trabajadors', 'dni')->ignore($this->trabajador->id)->whereNull('deleted_at')],
            'activo' => 'required|boolean',
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user->id)],
            'especialidad_id' => 'required|exists:especialidads,id',
            'cargo_id' => 'required|exists:cargos,id',
            'registro_profesional' => 'nullable|string|max:100',
        ];
    }

    public function validationAttributes()
    {
        return [
            'nombre' => 'nombre completo',
            'dni' => 'DNI/RUC',
            'name' => 'usuario login',
            'email' => 'correo electrónico',
            'especialidad_id' => 'especialidad',
            'cargo_id' => 'cargo',
            'registro_profesional' => 'registro profesional',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        // $this->authorize('trabajador.editar');

        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', [
                'type' => 'warning',
                'title' => 'Datos Inválidos',
                'text' => 'Verifique los errores en los campos resaltados.',
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

            $this->trabajador->update([
                'nombre' => trim($this->nombre),
                'dni' => trim($this->dni) ?: null,
                'especialidad_id' => $this->especialidad_id,
                'cargo_id' => $this->cargo_id,
                'registro_profesional' => trim($this->registro_profesional) ?: null,
                'activo' => $this->activo,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Actualizado!',
                'text' => 'Los datos del trabajador se han actualizado correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-trabajador')->error('[TRABAJADOR] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->trabajador->id,
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo actualizar la información.',
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
            'text' => 'Se ha enviado un enlace para restablecer la contraseña a '.$this->email,
        ]);
    }

    #[On('eliminarTrabajadorOn')]
    public function eliminarTrabajadorOn()
    {
        // $this->authorize('trabajador.eliminar');

        try {
            DB::beginTransaction();
            $this->trabajador->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminado',
                'text' => 'El trabajador ha sido eliminado correctamente.',
            ]);

            return redirect()->route('erp.trabajador.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-trabajador')->error('[TRABAJADOR] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->trabajador->id,
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo eliminar el registro.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.trabajador.trabajador-editar', [
            'especialidades' => Especialidad::where('activo', true)->orderBy('nombre')->get(),
            'cargos' => Cargo::where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
