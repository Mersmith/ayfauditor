<?php

namespace App\Livewire\Erp\CategoriaPregunta;

use App\Models\CategoriaPregunta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Crear Categoría')]
class CategoriaPreguntaCrear extends Component
{
    public string $nombre = '';

    public string $descripcion = '';

    public string $color = '';

    public string $icono = '';

    public bool $activo = true;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'color' => 'nullable|string|max:50',
        'icono' => 'nullable|string|max:100',
        'activo' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        CategoriaPregunta::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'color' => $this->color,
            'icono' => $this->icono,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Categoría creada correctamente.');

        return $this->redirect(route('erp.categoria-pregunta.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.categoria-pregunta.categoria-pregunta-crear');
    }
}
