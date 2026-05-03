<?php

namespace App\Livewire\Erp\Respuesta;

use App\Models\Auditoria;
use App\Models\EstadoRespuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Nueva Respuesta')]
class RespuestaCrear extends Component
{
    public ?int $auditoria_id = null;

    public ?int $pregunta_id = null;

    public ?int $estado_respuesta_id = null;

    public string $respuesta_cliente = '';

    public ?string $fecha_inicio = null;

    public ?string $fecha_fin = null;

    protected $rules = [
        'auditoria_id' => 'required|exists:auditorias,id',
        'pregunta_id' => 'required|exists:preguntas,id',
        'estado_respuesta_id' => 'required|exists:estado_respuestas,id',
        'respuesta_cliente' => 'nullable|string',
        'fecha_inicio' => 'nullable|date',
        'fecha_fin' => 'nullable|date',
    ];

    public function mount()
    {
        $this->estado_respuesta_id = EstadoRespuesta::first()?->id;
    }

    public function save()
    {
        $this->validate();

        Respuesta::create([
            'auditoria_id' => $this->auditoria_id,
            'pregunta_id' => $this->pregunta_id,
            'estado_respuesta_id' => $this->estado_respuesta_id,
            'respuesta_cliente' => $this->respuesta_cliente,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ]);

        session()->flash('success', 'Respuesta registrada correctamente.');

        return $this->redirect(route('erp.respuesta.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.respuesta.respuesta-crear', [
            'auditorias' => Auditoria::all(),
            'preguntas' => Pregunta::all(),
            'estados' => EstadoRespuesta::all(),
        ]);
    }
}
