<?php

namespace App\Livewire\Erp\Respuesta;

use App\Models\EstadoRespuesta;
use App\Models\Respuesta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Respuesta')]
class RespuestaEditar extends Component
{
    public Respuesta $respuesta;

    public ?int $estado_respuesta_id = null;

    public string $respuesta_cliente = '';

    public ?string $fecha_inicio = null;

    public ?string $fecha_fin = null;

    public function mount($id)
    {
        $this->respuesta = Respuesta::with(['auditoria', 'pregunta'])->findOrFail($id);
        $this->estado_respuesta_id = $this->respuesta->estado_respuesta_id;
        $this->respuesta_cliente = $this->respuesta->respuesta_cliente ?? '';
        $this->fecha_inicio = $this->respuesta->fecha_inicio;
        $this->fecha_fin = $this->respuesta->fecha_fin;
    }

    protected $rules = [
        'estado_respuesta_id' => 'required|exists:estado_respuestas,id',
        'respuesta_cliente' => 'nullable|string',
        'fecha_inicio' => 'nullable|date',
        'fecha_fin' => 'nullable|date',
    ];

    public function update()
    {
        $this->validate();

        $this->respuesta->update([
            'estado_respuesta_id' => $this->estado_respuesta_id,
            'respuesta_cliente' => $this->respuesta_cliente,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ]);

        session()->flash('success', 'Respuesta actualizada correctamente.');

        return $this->redirect(route('erp.respuesta.vista.lista'), navigate: true);
    }

    public function delete()
    {
        $this->respuesta->delete();
        session()->flash('success', 'Respuesta eliminada.');

        return $this->redirect(route('erp.respuesta.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.respuesta.respuesta-editar', [
            'estados' => EstadoRespuesta::all(),
        ]);
    }
}
