<?php

namespace App\Livewire\Erp\Trabajador;

use App\Models\Cargo;
use App\Models\Especialidad;
use App\Models\Trabajador;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Integrante')]
class TrabajadorEditar extends Component
{
    public Trabajador $trabajador;

    public string $nombre = '';
    public string $dni = '';
    public $especialidad_id;
    public $cargo_id;
    public string $registro_profesional = '';
    public bool $activo = true;

    public function mount($id)
    {
        $this->trabajador = Trabajador::with('user')->findOrFail($id);
        $this->nombre = $this->trabajador->nombre;
        $this->dni = $this->trabajador->dni ?? '';
        $this->especialidad_id = $this->trabajador->especialidad_id;
        $this->cargo_id = $this->trabajador->cargo_id;
        $this->registro_profesional = $this->trabajador->registro_profesional ?? '';
        $this->activo = (bool) $this->trabajador->activo;
    }

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'dni' => ['nullable', 'string', 'max:20', Rule::unique('trabajadors', 'dni')->ignore($this->trabajador->id)],
            'especialidad_id' => ['nullable', 'exists:especialidads,id'],
            'cargo_id' => ['nullable', 'exists:cargos,id'],
            'registro_profesional' => ['nullable', 'string'],
            'activo' => ['boolean'],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->trabajador->update([
            'nombre' => $this->nombre,
            'dni' => $this->dni,
            'especialidad_id' => $this->especialidad_id,
            'cargo_id' => $this->cargo_id,
            'registro_profesional' => $this->registro_profesional,
            'activo' => $this->activo,
        ]);

        // Sincronizar nombre en usuario también
        $this->trabajador->user->update([
            'name' => $this->nombre,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Información actualizada correctamente.');

        return $this->redirect(route('erp.trabajador.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.trabajador.trabajador-editar', [
            'especialidades' => Especialidad::where('activo', true)->get(),
            'cargos' => Cargo::where('activo', true)->get(),
        ]);
    }
}
