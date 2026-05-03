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

    public string $slug = '';

    public string $tipo = 'administrativo';

    public string $descripcion = '';

    public string $color = '';

    public string $icono = '';

    public bool $activo = true;

    public function mount($id)
    {
        $this->cargo = Cargo::findOrFail($id);
        $this->nombre = $this->cargo->nombre;
        $this->slug = $this->cargo->slug ?? '';
        $this->tipo = $this->cargo->tipo;
        $this->descripcion = $this->cargo->descripcion ?? '';
        $this->color = $this->cargo->color ?? '';
        $this->icono = $this->cargo->icono ?? '';
        $this->activo = $this->cargo->activo;
    }

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('cargos', 'nombre')->ignore($this->cargo->id)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('cargos', 'slug')->ignore($this->cargo->id)],
            'tipo' => ['required', 'in:administrativo,auditoria'],
            'descripcion' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:50'],
            'icono' => ['nullable', 'string', 'max:100'],
            'activo' => ['boolean'],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->cargo->update([
            'nombre' => $this->nombre,
            'slug' => $this->slug ?: null,
            'tipo' => $this->tipo,
            'descripcion' => $this->descripcion,
            'color' => $this->color,
            'icono' => $this->icono,
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
