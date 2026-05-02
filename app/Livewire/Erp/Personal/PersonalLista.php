<?php

namespace App\Livewire\Erp\Personal;

use App\Models\Personal;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Personal de Empresas')]
class PersonalLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.personal.personal-lista', [
            'personals' => Personal::with(['user', 'empresas'])->paginate(10),
        ]);
    }
}
