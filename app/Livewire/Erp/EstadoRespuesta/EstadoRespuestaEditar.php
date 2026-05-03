<?php

namespace App\Livewire\Erp\EstadoRespuesta;

use App\Models\EstadoRespuesta;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Estado de Respuesta')]
class EstadoRespuestaEditar extends Component
{
    public EstadoRespuesta $estado;

    public string $nombre = '';

    public string $descripcion = '';

    public string $color = '';

    public string $icono = '';

    public bool $activo = true;

    public function mount($id)
    {
        $this->estado = EstadoRespuesta::findOrFail($id);
        $this->nombre = $this->estado->nombre;
        $this->descripcion = $this->estado->descripcion ?? '';
        $this->color = $this->estado->color ?? '';
        $this->icono = $this->estado->icono ?? '';
        $this->activo = $this->estado->activo;
    }

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('estado_respuestas', 'nombre')->ignore($this->estado->id)],
            'descripcion' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:50'],
            'icono' => ['nullable', 'string', 'max:100'],
            'activo' => ['boolean'],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->estado->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'color' => $this->color,
            'icono' => $this->icono,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Estado de respuesta actualizado correctamente.');

        return $this->redirect(route('erp.estado-respuesta.vista.lista'), navigate: true);
    }

    public function delete()
    {
        $this->estado->delete();
        session()->flash('success', 'Estado de respuesta eliminado.');

        return $this->redirect(route('erp.estado-respuesta.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.estado-respuesta.estado-respuesta-editar');
    }
}
