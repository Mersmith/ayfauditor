<?php

namespace App\Livewire\Erp\Plantilla;

use App\Models\Plantilla;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Plantillas de Auditoría')]
class PlantillaLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.plantilla.plantilla-lista', [
            'plantillas' => Plantilla::withCount('preguntas')->paginate(10),
        ]);
    }
}
