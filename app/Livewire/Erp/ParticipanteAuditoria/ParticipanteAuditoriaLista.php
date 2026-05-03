<?php

namespace App\Livewire\Erp\ParticipanteAuditoria;

use App\Exports\ParticipantesAuditoriaExport;
use App\Models\Auditoria;
use App\Models\ParticipanteAuditoria;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy]
#[Layout('layouts.erp.layout-erp', ['anchoPantalla' => '100%'])]
#[Title('Participantes de Auditoría')]
class ParticipanteAuditoriaLista extends Component
{
    use WithPagination;

    #[Url]
    public $auditoria_id = '';

    #[Url]
    public $user_id = '';

    #[Url]
    public $perPage = 20;

    #[Url]
    public $desde = '';

    #[Url]
    public $hasta = '';

    public function updated($property)
    {
        if (in_array($property, ['auditoria_id', 'user_id', 'perPage', 'desde', 'hasta'])) {
            $this->resetPage();
        }
    }

    public function resetFiltros()
    {
        $this->reset(['auditoria_id', 'user_id', 'desde', 'hasta']);
        $this->perPage = 20;
        $this->resetPage();
    }

    public function exportExcelFiltro()
    {
        // $this->authorize('participante-auditoria.exportar-filtro');

        return Excel::download(
            new ParticipantesAuditoriaExport(
                auditoria_id: $this->auditoria_id,
                user_id: $this->user_id,
                perPage: $this->perPage,
                page: $this->getPage(),
                desde: $this->desde,
                hasta: $this->hasta,
                todo: false
            ),
            'participantes_filtrados_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function exportExcelTodo()
    {
        // $this->authorize('participante-auditoria.exportar-todo');

        return Excel::download(
            new ParticipantesAuditoriaExport(
                desde: $this->desde,
                hasta: $this->hasta,
                todo: true
            ),
            'participantes_completos_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function render()
    {
        $items = ParticipanteAuditoria::with(['auditoria', 'user', 'cargo', 'invitadoPor'])
            ->when($this->auditoria_id, function ($query) {
                $query->where('auditoria_id', $this->auditoria_id);
            })
            ->when($this->user_id, function ($query) {
                $query->where('user_id', $this->user_id);
            })
            ->when($this->desde, fn ($q) => $q->whereDate('created_at', '>=', $this->desde))
            ->when($this->hasta, fn ($q) => $q->whereDate('created_at', '<=', $this->hasta))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.erp.participante-auditoria.participante-auditoria-lista', [
            'items' => $items,
            'auditorias' => Auditoria::orderBy('titulo')->get(),
            'usuarios' => User::orderBy('name')->get(),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
