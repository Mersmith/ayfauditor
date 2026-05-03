<?php

namespace App\Livewire\Erp\Cargo;

use App\Models\Cargo;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Crear Cargo')]
class CargoCrear extends Component
{
    public string $nombre = '';

    public string $slug = '';

    public string $tipo = 'administrativo';

    public string $descripcion = '';

    public string $color = '';

    public string $icono = '';

    public bool $activo = true;

    protected $rules = [
        'nombre' => 'required|string|max:255|unique:cargos,nombre',
        'slug' => 'nullable|string|max:255|unique:cargos,slug',
        'tipo' => 'required|in:administrativo,auditoria',
        'descripcion' => 'nullable|string',
        'color' => 'nullable|string|max:50',
        'icono' => 'nullable|string|max:100',
        'activo' => 'boolean',
    ];

    public function updatedNombre($value)
    {
        if ($this->tipo === 'auditoria') {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate();

        Cargo::create([
            'nombre' => $this->nombre,
            'slug' => $this->slug ?: null,
            'tipo' => $this->tipo,
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
