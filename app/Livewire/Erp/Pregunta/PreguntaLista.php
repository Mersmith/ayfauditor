<?php

namespace App\Livewire\Erp\Pregunta;

use App\Models\Pregunta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Banco de Preguntas')]
class PreguntaLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.pregunta.pregunta-lista', [
            'preguntas' => Pregunta::with('categoria')->paginate(20),
        ]);
    }
}
