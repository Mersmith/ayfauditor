<?php

namespace App\Livewire\Erp\Personal;

use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\Personal;
use App\Models\PersonalEmpresa;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Registrar Personal')]
class PersonalCrear extends Component
{
    public string $nombre = '';
    public string $dni = '';
    public string $celular = '';
    public bool $activo = true;

    // Relación opcional inmediata con una empresa
    public $empresa_id;
    public $cargo_id;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'dni' => 'nullable|string|max:20|unique:personals,dni',
        'celular' => 'nullable|string|max:20',
        'activo' => 'boolean',
        'empresa_id' => 'nullable|exists:empresas,id',
        'cargo_id' => 'nullable|exists:cargos,id',
    ];

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            $personal = Personal::create([
                'nombre' => $this->nombre,
                'dni' => $this->dni,
                'celular' => $this->celular,
                'activo' => $this->activo,
            ]);

            // Si se seleccionó empresa, crear la relación
            if ($this->empresa_id) {
                PersonalEmpresa::create([
                    'personal_id' => $personal->id,
                    'empresa_id' => $this->empresa_id,
                    'cargo_id' => $this->cargo_id,
                    'activo' => true,
                ]);
            }
        });

        session()->flash('success', 'Personal registrado correctamente.');

        return $this->redirect(route('erp.personal.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.personal.personal-crear', [
            'empresas' => Empresa::where('activo', true)->get(),
            'cargos' => Cargo::where('activo', true)->get(),
        ]);
    }
}
