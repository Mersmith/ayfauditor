<?php

namespace App\Livewire\Erp\Cargo;

use App\Models\Cargo;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Crear Cargo')]
class CargoCrear extends Component
{
    public string $nombre = '';
    public string $descripcion = '';
    public bool $activo = true;

    protected $rules = [
        'nombre' => 'required|string|max:255|unique:cargos,nombre',
        'descripcion' => 'nullable|string',
        'activo' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        Cargo::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Cargo creado correctamente.');

        return $this->redirect(route('erp.cargo.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.cargo.cargo-crear');
    }
}
