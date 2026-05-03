<?php

namespace App\Livewire\Erp\EstadoRespuesta;

use App\Models\EstadoRespuesta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Estados de Respuesta')]
class EstadoRespuestaLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.estado-respuesta.estado-respuesta-lista', [
            'estados' => EstadoRespuesta::paginate(10),
        ]);
    }
}
