<?php

namespace App\Livewire\Erp\Trabajador;

use App\Models\Cargo;
use App\Models\Especialidad;
use App\Models\Trabajador;
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
#[Title('Registrar Trabajador')]
class TrabajadorCrear extends Component
{
    // Datos Personales
    public $nombre = '';

    public $dni = '';

    public $activo = true;

    // Datos de Acceso
    public $name = '';

    public $email = '';

    public $password = '';

    // Perfil Profesional
    public $especialidad_id = '';

    public $cargo_id = '';

    public $registro_profesional = '';

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'dni' => 'nullable|string|max:20|unique:trabajadors,dni',
            'activo' => 'required|boolean',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
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
            'password' => 'contraseña',
            'especialidad_id' => 'especialidad',
            'cargo_id' => 'cargo',
            'registro_profesional' => 'registro profesional',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        // $this->authorize('trabajador.crear');

        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', [
                'type' => 'warning',
                'title' => 'Datos Incompletos',
                'text' => 'Verifique los errores en los campos resaltados.',
            ]);
            throw $e;
        }

        try {
            DB::beginTransaction();

            // 1. Crear Usuario
            $user = User::create([
                'name' => trim($this->name),
                'email' => strtolower(trim($this->email)),
                'password' => Hash::make($this->password),
                'activo' => $this->activo,
            ]);

            // 2. Crear Trabajador
            Trabajador::create([
                'user_id' => $user->id,
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
                'title' => '¡Éxito!',
                'text' => 'El trabajador se ha registrado correctamente.',
            ]);

            return redirect()->route('erp.trabajador.vista.lista');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-trabajador')->error('[TRABAJADOR] Error al crear: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo registrar al trabajador. Intente nuevamente.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.trabajador.trabajador-crear', [
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
