<?php

namespace App\Livewire\Erp\Plantilla;

use App\Models\Plantilla;
use App\Models\Pregunta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Crear Plantilla')]
class PlantillaCrear extends Component
{
    public string $nombre = '';

    public string $descripcion = '';

    public bool $activo = true;

    public array $preguntas_seleccionadas = [];

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'activo' => 'boolean',
        'preguntas_seleccionadas' => 'required|array|min:1',
        'preguntas_seleccionadas.*' => 'exists:preguntas,id',
    ];

    public function save()
    {
        $this->validate();

        $plantilla = Plantilla::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'activo' => $this->activo,
        ]);

        foreach ($this->preguntas_seleccionadas as $index => $preguntaId) {
            $plantilla->preguntas()->attach($preguntaId, ['orden' => ($index + 1) * 10]);
        }

        session()->flash('success', 'Plantilla creada correctamente.');

        return $this->redirect(route('erp.plantilla.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.plantilla.plantilla-crear', [
            'bancoPreguntas' => Pregunta::with('categoria')->where('activo', true)->get(),
        ]);
    }
}
