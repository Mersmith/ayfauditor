<?php

namespace App\Livewire\Erp\Cargo;

use App\Models\Cargo;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Cargo')]
class CargoEditar extends Component
{
    public Cargo $cargo;

    public string $nombre = '';
    public string $descripcion = '';
    public bool $activo = true;

    public function mount($id)
    {
        $this->cargo = Cargo::findOrFail($id);
        $this->nombre = $this->cargo->nombre;
        $this->descripcion = $this->cargo->descripcion ?? '';
        $this->activo = $this->cargo->activo;
    }

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('cargos', 'nombre')->ignore($this->cargo->id)],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['boolean'],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->cargo->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Cargo actualizado correctamente.');

        return $this->redirect(route('erp.cargo.vista.lista'), navigate: true);
    }

    public function delete()
    {
        $this->cargo->delete();
        session()->flash('success', 'Cargo eliminado.');
        return $this->redirect(route('erp.cargo.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.cargo.cargo-editar');
    }
}
