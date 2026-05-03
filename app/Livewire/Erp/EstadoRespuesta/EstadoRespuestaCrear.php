<?php

namespace App\Livewire\Erp\EstadoRespuesta;

use App\Models\EstadoRespuesta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Crear Estado de Respuesta')]
class EstadoRespuestaCrear extends Component
{
    public string $nombre = '';

    public string $descripcion = '';

    public string $color = '';

    public string $icono = '';

    public bool $activo = true;

    protected $rules = [
        'nombre' => 'required|string|max:255|unique:estado_respuestas,nombre',
        'descripcion' => 'nullable|string',
        'color' => 'nullable|string|max:50',
        'icono' => 'nullable|string|max:100',
        'activo' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        EstadoRespuesta::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'color' => $this->color,
            'icono' => $this->icono,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Estado de respuesta creado correctamente.');

        return $this->redirect(route('erp.estado-respuesta.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.estado-respuesta.estado-respuesta-crear');
    }
}
