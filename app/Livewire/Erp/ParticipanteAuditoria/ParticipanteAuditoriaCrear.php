<?php

namespace App\Livewire\Erp\ParticipanteAuditoria;

use App\Models\Auditoria;
use App\Models\Cargo;
use App\Models\ParticipanteAuditoria;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Agregar Participante')]
class ParticipanteAuditoriaCrear extends Component
{
    public ?int $auditoria_id = null;

    public ?int $user_id = null;

    public ?int $cargo_id = null;

    public ?int $invitado_por = null;

    protected $rules = [
        'auditoria_id' => 'required|exists:auditorias,id',
        'user_id' => 'required|exists:users,id',
        'cargo_id' => 'required|exists:cargos,id',
        'invitado_por' => 'nullable|exists:users,id',
    ];

    public function save()
    {
        $this->validate();

        // Evitar duplicados
        $exists = ParticipanteAuditoria::where('auditoria_id', $this->auditoria_id)
            ->where('user_id', $this->user_id)
            ->exists();

        if ($exists) {
            $this->addError('user_id', 'Este usuario ya participa en esta auditoría.');

            return;
        }

        ParticipanteAuditoria::create([
            'auditoria_id' => $this->auditoria_id,
            'user_id' => $this->user_id,
            'cargo_id' => $this->cargo_id,
            'invitado_por' => $this->invitado_por,
        ]);

        session()->flash('success', 'Participante agregado correctamente.');

        return $this->redirect(route('erp.participante-auditoria.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.participante-auditoria.participante-auditoria-crear', [
            'auditorias' => Auditoria::orderBy('created_at', 'desc')->get(),
            'usuarios' => User::with(['cliente', 'trabajador', 'personal'])->where('activo', true)->get(),
            'cargos' => Cargo::where('tipo', 'auditoria')->where('activo', true)->get(),
        ]);
    }
}
