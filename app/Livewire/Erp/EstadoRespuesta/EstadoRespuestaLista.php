<?php

namespace App\Livewire\Erp\EstadoRespuesta;

use App\Exports\EstadoRespuestaExport;
use App\Models\EstadoRespuesta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy]
#[Layout('layouts.erp.layout-erp', ['anchoPantalla' => '100%'])]
#[Title('Estados de Respuesta')]
class EstadoRespuestaLista extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $buscar = '';

    #[Url]
    public $activo = '';

    #[Url]
    public $perPage = 20;

    #[Url]
    public $desde = '';

    #[Url]
    public $hasta = '';

    public function updated($property)
    {
        if (in_array($property, ['buscar', 'activo', 'perPage', 'desde', 'hasta'])) {
            $this->resetPage();
        }
    }

    public function resetFiltros()
    {
        $this->reset(['buscar', 'activo', 'desde', 'hasta']);
        $this->perPage = 20;
        $this->resetPage();
    }

    public function exportExcelFiltro()
    {
        // $this->authorize('estado-respuesta.exportar-filtro');

        return Excel::download(
            new EstadoRespuestaExport(
                buscar: $this->buscar,
                activo: $this->activo,
                perPage: $this->perPage,
                page: $this->getPage(),
                desde: $this->desde,
                hasta: $this->hasta,
                todo: false
            ),
            'estados_respuesta_filtrados_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function exportExcelTodo()
    {
        // $this->authorize('estado-respuesta.exportar-todo');

        return Excel::download(
            new EstadoRespuestaExport(
                desde: $this->desde,
                hasta: $this->hasta,
                todo: true
            ),
            'estados_respuesta_completos_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function render()
    {
        $items = EstadoRespuesta::query()
            ->when($this->buscar, function ($query) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', "%{$this->buscar}%");

                    if (is_numeric($this->buscar)) {
                        $q->orWhere('id', (int) $this->buscar);
                    }
                });
            })
            ->when($this->activo !== '', function ($query) {
                $query->where('activo', $this->activo);
            })
            ->when($this->desde, fn ($q) => $q->whereDate('created_at', '>=', $this->desde))
            ->when($this->hasta, fn ($q) => $q->whereDate('created_at', '<=', $this->hasta))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.erp.estado-respuesta.estado-respuesta-lista', compact('items'));
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
