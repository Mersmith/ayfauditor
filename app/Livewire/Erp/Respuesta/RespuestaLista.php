<?php

namespace App\Livewire\Erp\Respuesta;

use App\Models\Auditoria;
use App\Models\Respuesta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Respuestas de Auditoría')]
class RespuestaLista extends Component
{
    use WithPagination;

    public ?int $auditoria_id = null;

    public function render()
    {
        $query = Respuesta::with(['auditoria', 'pregunta', 'estado', 'creator']);

        if ($this->auditoria_id) {
            $query->where('auditoria_id', $this->auditoria_id);
        }

        return view('livewire.erp.respuesta.respuesta-lista', [
            'respuestas' => $query->paginate(20),
            'auditorias' => Auditoria::orderBy('created_at', 'desc')->get(),
        ]);
    }
}
