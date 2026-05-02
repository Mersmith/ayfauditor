<?php

namespace App\Livewire\Erp\Trabajador;

use App\Models\Cargo;
use App\Models\Especialidad;
use App\Models\Trabajador;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Registrar Integrante de Equipo')]
class TrabajadorCrear extends Component
{
    // Datos de Usuario
    public string $email = '';
    public string $password = '';

    // Datos de Trabajador
    public string $nombre = '';
    public string $dni = '';
    public $especialidad_id;
    public $cargo_id;
    public string $registro_profesional = '';
    public bool $activo = true;

    protected $rules = [
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'nombre' => 'required|string|max:255',
        'dni' => 'nullable|string|max:20|unique:trabajadors,dni',
        'especialidad_id' => 'nullable|exists:especialidads,id',
        'cargo_id' => 'nullable|exists:cargos,id',
        'registro_profesional' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // 1. Crear el Usuario
            $user = User::create([
                'name' => $this->nombre,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'activo' => $this->activo,
            ]);

            // 2. Crear el Perfil de Trabajador
            Trabajador::create([
                'user_id' => $user->id,
                'nombre' => $this->nombre,
                'dni' => $this->dni,
                'especialidad_id' => $this->especialidad_id,
                'cargo_id' => $this->cargo_id,
                'registro_profesional' => $this->registro_profesional,
                'activo' => $this->activo,
            ]);
        });

        session()->flash('success', 'Integrante registrado correctamente.');

        return $this->redirect(route('erp.trabajador.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.trabajador.trabajador-crear', [
            'especialidades' => Especialidad::where('activo', true)->get(),
            'cargos' => Cargo::where('activo', true)->get(),
        ]);
    }
}
