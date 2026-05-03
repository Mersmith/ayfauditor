<?php

namespace App\Livewire\Erp\Personal;

use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\Personal;
use App\Models\PersonalEmpresa;
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
#[Title('Editar Personal')]
class PersonalEditar extends Component
{
    public Personal $personal;

    public ?User $user = null;

    // Campos Personal
    public $nombre;

    public $dni;

    public $celular;

    public $activo;

    // Campos Usuario (Login)
    public $name;

    public $email;

    // Campos Asignación (Siguiendo patrón de PersonalCrear)
    public $empresa_id = '';

    public $cargo_id = '';

    public function mount($id)
    {
        $this->personal = Personal::with(['user', 'personalEmpresas' => function ($q) {
            $q->where('activo', true)->latest();
        }])->findOrFail($id);

        $this->user = $this->personal->user;

        $this->nombre = $this->personal->nombre;
        $this->dni = $this->personal->dni ?? '';
        $this->celular = $this->personal->celular ?? '';
        $this->activo = (bool) $this->personal->activo;

        if ($this->user) {
            $this->name = $this->user->name;
            $this->email = $this->user->email;
        }

        // Cargar asignación actual (primera activa encontrada)
        $asignacion = $this->personal->personalEmpresas->first();
        if ($asignacion) {
            $this->empresa_id = $asignacion->empresa_id;
            $this->cargo_id = $asignacion->cargo_id;
        }
    }

    protected function rules()
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'dni' => ['nullable', 'string', 'max:20', Rule::unique('personals', 'dni')->ignore($this->personal->id)->whereNull('deleted_at')],
            'celular' => 'nullable|string|max:50',
            'activo' => 'required|boolean',
            'empresa_id' => 'nullable|exists:empresas,id',
            'cargo_id' => 'nullable|exists:cargos,id',
        ];

        if ($this->user) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = ['required', 'email', Rule::unique('users', 'email')->ignore($this->user->id)];
        }

        return $rules;
    }

    public function validationAttributes()
    {
        return [
            'nombre' => 'nombre completo',
            'dni' => 'DNI/RUC',
            'celular' => 'teléfono/celular',
            'name' => 'usuario login',
            'email' => 'correo electrónico',
            'empresa_id' => 'empresa',
            'cargo_id' => 'cargo',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        // $this->authorize('personal.editar');

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

            $this->personal->update([
                'nombre' => trim($this->nombre),
                'dni' => trim($this->dni) ?: null,
                'celular' => trim($this->celular) ?: null,
                'activo' => $this->activo,
            ]);

            if ($this->user) {
                $this->user->update([
                    'name' => trim($this->name),
                    'email' => strtolower(trim($this->email)),
                    'activo' => $this->activo,
                ]);
            }

            // Actualizar o crear asignación
            if ($this->empresa_id) {
                PersonalEmpresa::updateOrCreate(
                    [
                        'personal_id' => $this->personal->id,
                        'empresa_id' => $this->empresa_id,
                    ],
                    [
                        'cargo_id' => $this->cargo_id ?: null,
                        'activo' => true,
                    ]
                );
            }

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Actualizado!',
                'text' => 'Los datos del personal se han actualizado correctamente.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-personal')->error('[PERSONAL] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->personal->id,
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
        if (! $this->user) {
            $this->dispatch('alertaLivewire', [
                'type' => 'warning',
                'title' => 'Sin Usuario',
                'text' => 'Este perfil no tiene un usuario de acceso vinculado.',
            ]);

            return;
        }

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

    #[On('eliminarPersonalOn')]
    public function eliminarPersonalOn()
    {
        // $this->authorize('personal.eliminar');

        try {
            DB::beginTransaction();
            $this->personal->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminado',
                'text' => 'El registro ha sido eliminado correctamente.',
            ]);

            return redirect()->route('erp.personal.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-personal')->error('[PERSONAL] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->personal->id,
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
        return view('livewire.erp.personal.personal-editar', [
            'empresas' => Empresa::where('activo', true)->orderBy('razon_social')->get(),
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
