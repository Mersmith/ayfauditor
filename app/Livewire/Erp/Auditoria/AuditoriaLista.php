<?php

namespace App\Livewire\Erp\Auditoria;

use App\Exports\AuditoriasExport;
use App\Models\Auditoria;
use App\Models\Empresa;
use App\Models\EstadoAuditoria;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy]
#[Layout('layouts.erp.layout-erp', ['anchoPantalla' => '100%'])]
#[Title('Gestión de Auditorías')]
class AuditoriaLista extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $buscar = '';

    #[Url]
    public $empresa_id = '';

    #[Url]
    public $estado_id = '';

    #[Url]
    public $perPage = 20;

    #[Url]
    public $desde = '';

    #[Url]
    public $hasta = '';

    public function updated($property)
    {
        if (in_array($property, ['buscar', 'empresa_id', 'estado_id', 'perPage', 'desde', 'hasta'])) {
            $this->resetPage();
        }
    }

    public function resetFiltros()
    {
        $this->reset(['buscar', 'empresa_id', 'estado_id', 'desde', 'hasta']);
        $this->perPage = 20;
        $this->resetPage();
    }

    public function exportExcelFiltro()
    {
        // $this->authorize('auditoria.exportar-filtro');

        return Excel::download(
            new AuditoriasExport(
                buscar: $this->buscar,
                empresa_id: $this->empresa_id,
                estado_id: $this->estado_id,
                perPage: $this->perPage,
                page: $this->getPage(),
                desde: $this->desde,
                hasta: $this->hasta,
                todo: false
            ),
            'auditorias_filtradas_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function exportExcelTodo()
    {
        // $this->authorize('auditoria.exportar-todo');

        return Excel::download(
            new AuditoriasExport(
                desde: $this->desde,
                hasta: $this->hasta,
                todo: true
            ),
            'auditorias_completas_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function render()
    {
        $items = Auditoria::with(['empresa', 'plantilla', 'estado'])
            ->when($this->buscar, function ($query) {
                $query->where('titulo', 'like', "%{$this->buscar}%");

                if (is_numeric($this->buscar)) {
                    $query->orWhere('id', (int) $this->buscar);
                }
            })
            ->when($this->empresa_id, function ($query) {
                $query->where('empresa_id', $this->empresa_id);
            })
            ->when($this->estado_id, function ($query) {
                $query->where('estado_auditoria_id', $this->estado_id);
            })
            ->when($this->desde, fn ($q) => $q->whereDate('created_at', '>=', $this->desde))
            ->when($this->hasta, fn ($q) => $q->whereDate('created_at', '<=', $this->hasta))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.erp.auditoria.auditoria-lista', [
            'items' => $items,
            'empresas' => Empresa::where('activo', true)->orderBy('razon_social')->get(),
            'estados' => EstadoAuditoria::where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
