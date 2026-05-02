<?php

namespace App\Livewire\Erp\Cargo;

use App\Models\Cargo;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Cargos')]
class CargoLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.cargo.cargo-lista', [
            'cargos' => Cargo::paginate(10),
        ]);
    }
}
