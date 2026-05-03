<?php

namespace App\Livewire\Erp\EstadoAuditoria;

use App\Models\EstadoAuditoria;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Estados de Auditoría')]
class EstadoAuditoriaLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.estado-auditoria.estado-auditoria-lista', [
            'estados' => EstadoAuditoria::paginate(10),
        ]);
    }
}
