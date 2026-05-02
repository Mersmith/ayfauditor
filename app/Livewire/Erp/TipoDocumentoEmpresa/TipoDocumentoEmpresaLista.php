<?php

namespace App\Livewire\Erp\TipoDocumentoEmpresa;

use App\Models\TipoDocumentoEmpresa;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Tipos de Documento Empresa')]
class TipoDocumentoEmpresaLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.tipo-documento-empresa.tipo-documento-empresa-lista', [
            'tipos' => TipoDocumentoEmpresa::paginate(10),
        ]);
    }
}
