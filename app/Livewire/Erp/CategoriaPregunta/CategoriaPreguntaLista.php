<?php

namespace App\Livewire\Erp\CategoriaPregunta;

use App\Models\CategoriaPregunta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Categorías de Preguntas')]
class CategoriaPreguntaLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.categoria-pregunta.categoria-pregunta-lista', [
            'categorias' => CategoriaPregunta::paginate(10),
        ]);
    }
}
