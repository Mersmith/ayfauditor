<?php

namespace App\Livewire\Erp\Auditoria;

use App\Models\Auditoria;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Sesiones de Auditoría')]
class AuditoriaLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.auditoria.auditoria-lista', [
            'auditorias' => Auditoria::with(['empresa', 'plantilla', 'estado'])->paginate(10),
        ]);
    }
}
