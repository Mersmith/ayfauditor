<?php

namespace App\Livewire\Erp\Especialidad;

use App\Models\Especialidad;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Especialidad')]
class EspecialidadEditar extends Component
{
    public Especialidad $especialidad;

    public string $nombre = '';
    public string $descripcion = '';
    public bool $activo = true;

    public function mount($id)
    {
        $this->especialidad = Especialidad::findOrFail($id);
        $this->nombre = $this->especialidad->nombre;
        $this->descripcion = $this->especialidad->descripcion ?? '';
        $this->activo = $this->especialidad->activo;
    }

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('especialidads', 'nombre')->ignore($this->especialidad->id)],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['boolean'],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->especialidad->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Especialidad actualizada correctamente.');

        return $this->redirect(route('erp.especialidad.vista.lista'), navigate: true);
    }

    public function delete()
    {
        $this->especialidad->delete();
        session()->flash('success', 'Especialidad eliminada.');
        return $this->redirect(route('erp.especialidad.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.especialidad.especialidad-editar');
    }
}
