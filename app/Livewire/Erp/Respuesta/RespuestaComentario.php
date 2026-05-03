<?php

namespace App\Livewire\Erp\Respuesta;

use App\Models\ComentarioRespuesta;
use App\Models\Respuesta;
use Livewire\Component;

class RespuestaComentario extends Component
{
    public Respuesta $respuesta;

    public string $mensaje = '';

    protected $rules = [
        'mensaje' => 'required|string|min:3',
    ];

    public function saveComment()
    {
        $this->validate();

        ComentarioRespuesta::create([
            'respuesta_id' => $this->respuesta->id,
            'user_id' => auth()->id(),
            'mensaje' => $this->mensaje,
        ]);

        $this->mensaje = '';
        $this->respuesta->load('comentarios.user'); // Recargar para mostrar el nuevo

        session()->flash('message', 'Comentario enviado.');
    }

    public function render()
    {
        return view('livewire.erp.respuesta.respuesta-comentario', [
            'comentarios' => $this->respuesta->comentarios()->with('user')->orderBy('created_at', 'asc')->get(),
        ]);
    }
}
