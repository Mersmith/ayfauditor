<?php

namespace App\Livewire\Erp\Plantilla;

use App\Models\Plantilla;
use App\Models\Pregunta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Plantilla')]
class PlantillaEditar extends Component
{
    public Plantilla $plantilla;

    public string $nombre = '';

    public string $descripcion = '';

    public bool $activo = true;

    public array $preguntas_seleccionadas = [];

    public function mount($id)
    {
        $this->plantilla = Plantilla::with('preguntas')->findOrFail($id);
        $this->nombre = $this->plantilla->nombre;
        $this->descripcion = $this->plantilla->descripcion ?? '';
        $this->activo = $this->plantilla->activo;
        $this->preguntas_seleccionadas = $this->plantilla->preguntas->pluck('id')->map(fn ($id) => (string) $id)->toArray();
    }

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'activo' => 'boolean',
        'preguntas_seleccionadas' => 'required|array|min:1',
        'preguntas_seleccionadas.*' => 'exists:preguntas,id',
    ];

    public function update()
    {
        $this->validate();

        $this->plantilla->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'activo' => $this->activo,
        ]);

        $syncData = [];
        foreach ($this->preguntas_seleccionadas as $index => $preguntaId) {
            $syncData[$preguntaId] = ['orden' => ($index + 1) * 10];
        }

        $this->plantilla->preguntas()->sync($syncData);

        session()->flash('success', 'Plantilla actualizada correctamente.');

        return $this->redirect(route('erp.plantilla.vista.lista'), navigate: true);
    }

    public function delete()
    {
        $this->plantilla->delete();
        session()->flash('success', 'Plantilla eliminada.');

        return $this->redirect(route('erp.plantilla.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.plantilla.plantilla-editar', [
            'bancoPreguntas' => Pregunta::with('categoria')->where('activo', true)->get(),
        ]);
    }
}
