<?php

namespace App\Livewire\Erp\Pregunta;

use App\Models\CategoriaPregunta;
use App\Models\Pregunta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Crear Pregunta')]
class PreguntaCrear extends Component
{
    public string $texto = '';

    public ?int $categoria_pregunta_id = null;

    public string $descripcion_ayuda = '';

    public int $orden_sugerido = 0;

    public bool $activo = true;

    protected $rules = [
        'texto' => 'required|string|max:255',
        'categoria_pregunta_id' => 'nullable|exists:categoria_preguntas,id',
        'descripcion_ayuda' => 'nullable|string',
        'orden_sugerido' => 'required|integer',
        'activo' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        Pregunta::create([
            'texto' => $this->texto,
            'categoria_pregunta_id' => $this->categoria_pregunta_id,
            'descripcion_ayuda' => $this->descripcion_ayuda,
            'orden_sugerido' => $this->orden_sugerido,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Pregunta creada correctamente.');

        return $this->redirect(route('erp.pregunta.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.pregunta.pregunta-crear', [
            'categorias' => CategoriaPregunta::where('activo', true)->get(),
        ]);
    }
}
