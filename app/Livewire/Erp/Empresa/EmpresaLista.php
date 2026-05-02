<?php

namespace App\Livewire\Erp\Empresa;

use App\Models\Empresa;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Empresas')]
class EmpresaLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.empresa.empresa-lista', [
            'empresas' => Empresa::with(['cliente', 'tipoDocumento'])->paginate(10),
        ]);
    }
}
