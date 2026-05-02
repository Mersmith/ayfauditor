<?php

namespace App\Livewire\Erp\Especialidad;

use App\Models\Especialidad;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Especialidades')]
class EspecialidadLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.especialidad.especialidad-lista', [
            'especialidades' => Especialidad::paginate(10),
        ]);
    }
}
