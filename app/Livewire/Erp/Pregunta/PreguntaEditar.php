<?php

namespace App\Livewire\Erp\Pregunta;

use App\Models\CategoriaPregunta;
use App\Models\Pregunta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Pregunta')]
class PreguntaEditar extends Component
{
    public Pregunta $pregunta;

    public string $texto = '';

    public ?int $categoria_pregunta_id = null;

    public string $descripcion_ayuda = '';

    public int $orden_sugerido = 0;

    public bool $activo = true;

    public function mount($id)
    {
        $this->pregunta = Pregunta::findOrFail($id);
        $this->texto = $this->pregunta->texto;
        $this->categoria_pregunta_id = $this->pregunta->categoria_pregunta_id;
        $this->descripcion_ayuda = $this->pregunta->descripcion_ayuda ?? '';
        $this->orden_sugerido = $this->pregunta->orden_sugerido;
        $this->activo = $this->pregunta->activo;
    }

    protected $rules = [
        'texto' => 'required|string|max:255',
        'categoria_pregunta_id' => 'nullable|exists:categoria_preguntas,id',
        'descripcion_ayuda' => 'nullable|string',
        'orden_sugerido' => 'required|integer',
        'activo' => 'boolean',
    ];

    public function update()
    {
        $this->validate();

        $this->pregunta->update([
            'texto' => $this->texto,
            'categoria_pregunta_id' => $this->categoria_pregunta_id,
            'descripcion_ayuda' => $this->descripcion_ayuda,
            'orden_sugerido' => $this->orden_sugerido,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Pregunta actualizada correctamente.');

        return $this->redirect(route('erp.pregunta.vista.lista'), navigate: true);
    }

    public function delete()
    {
        $this->pregunta->delete();
        session()->flash('success', 'Pregunta eliminada.');

        return $this->redirect(route('erp.pregunta.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.pregunta.pregunta-editar', [
            'categorias' => CategoriaPregunta::where('activo', true)->get(),
        ]);
    }
}
