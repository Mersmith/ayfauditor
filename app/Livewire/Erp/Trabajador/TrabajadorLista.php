<?php

namespace App\Livewire\Erp\Trabajador;

use App\Models\Trabajador;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Equipo de Trabajo')]
class TrabajadorLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.trabajador.trabajador-lista', [
            'trabajadores' => Trabajador::with(['user', 'especialidad', 'cargo'])->paginate(10),
        ]);
    }
}
