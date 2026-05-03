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

    public string $color = '';

    public string $icono = '';

    public bool $activo = true;

    protected $rules = [
        'nombre' => 'required|string|max:255|unique:cargos,nombre',
        'descripcion' => 'nullable|string',
        'color' => 'nullable|string|max:50',
        'icono' => 'nullable|string|max:100',
        'activo' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        Cargo::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'color' => $this->color,
            'icono' => $this->icono,
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
