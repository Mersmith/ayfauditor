<?php

namespace App\Livewire\Erp\CategoriaPregunta;

use App\Models\CategoriaPregunta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Categoría')]
class CategoriaPreguntaEditar extends Component
{
    public CategoriaPregunta $categoria;

    public string $nombre = '';

    public string $descripcion = '';

    public string $color = '';

    public string $icono = '';

    public bool $activo = true;

    public function mount($id)
    {
        $this->categoria = CategoriaPregunta::findOrFail($id);
        $this->nombre = $this->categoria->nombre;
        $this->descripcion = $this->categoria->descripcion ?? '';
        $this->color = $this->categoria->color ?? '';
        $this->icono = $this->categoria->icono ?? '';
        $this->activo = $this->categoria->activo;
    }

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'color' => 'nullable|string|max:50',
        'icono' => 'nullable|string|max:100',
        'activo' => 'boolean',
    ];

    public function update()
    {
        $this->validate();

        $this->categoria->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'color' => $this->color,
            'icono' => $this->icono,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Categoría actualizada correctamente.');

        return $this->redirect(route('erp.categoria-pregunta.vista.lista'), navigate: true);
    }

    public function delete()
    {
        $this->categoria->delete();
        session()->flash('success', 'Categoría eliminada.');

        return $this->redirect(route('erp.categoria-pregunta.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.categoria-pregunta.categoria-pregunta-editar');
    }
}
