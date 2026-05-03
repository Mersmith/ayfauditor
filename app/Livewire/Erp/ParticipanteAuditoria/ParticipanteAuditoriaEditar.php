<?php

namespace App\Livewire\Erp\ParticipanteAuditoria;

use App\Models\Cargo;
use App\Models\ParticipanteAuditoria;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Participante')]
class ParticipanteAuditoriaEditar extends Component
{
    public ParticipanteAuditoria $participante;

    public int $cargo_id;

    public function mount($id)
    {
        $this->participante = ParticipanteAuditoria::with(['auditoria', 'user'])->findOrFail($id);
        $this->cargo_id = $this->participante->cargo_id;
    }

    protected $rules = [
        'cargo_id' => 'required|exists:cargos,id',
    ];

    public function update()
    {
        $this->validate();

        $this->participante->update([
            'cargo_id' => $this->cargo_id,
        ]);

        session()->flash('success', 'Rol del participante actualizado.');

        return $this->redirect(route('erp.participante-auditoria.vista.lista'), navigate: true);
    }

    public function delete()
    {
        $this->participante->delete();
        session()->flash('success', 'Participante eliminado de la auditoría.');

        return $this->redirect(route('erp.participante-auditoria.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.participante-auditoria.participante-auditoria-editar', [
            'cargos' => Cargo::where('tipo', 'auditoria')->where('activo', true)->get(),
        ]);
    }
}
