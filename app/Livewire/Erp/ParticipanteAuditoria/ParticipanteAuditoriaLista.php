<?php

namespace App\Livewire\Erp\ParticipanteAuditoria;

use App\Models\ParticipanteAuditoria;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Participantes de Auditoría')]
class ParticipanteAuditoriaLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.participante-auditoria.participante-auditoria-lista', [
            'participantes' => ParticipanteAuditoria::with(['auditoria', 'user', 'cargo', 'invitadoPor'])->paginate(20),
        ]);
    }
}
