<?php

namespace App\Livewire\Erp\Especialidad;

use App\Models\Especialidad;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Crear Especialidad')]
class EspecialidadCrear extends Component
{
    public string $nombre = '';

    public string $descripcion = '';

    public string $color = '';

    public string $icono = '';

    public bool $activo = true;

    protected $rules = [
        'nombre' => 'required|string|max:255|unique:especialidads,nombre',
        'descripcion' => 'nullable|string',
        'color' => 'nullable|string|max:50',
        'icono' => 'nullable|string|max:100',
        'activo' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        Especialidad::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'color' => $this->color,
            'icono' => $this->icono,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Especialidad creada correctamente.');

        return $this->redirect(route('erp.especialidad.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.especialidad.especialidad-crear');
    }
}
