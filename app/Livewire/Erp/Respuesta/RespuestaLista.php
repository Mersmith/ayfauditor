<?php

namespace App\Livewire\Erp\Respuesta;

use App\Exports\RespuestasExport;
use App\Models\Auditoria;
use App\Models\EstadoRespuesta;
use App\Models\Respuesta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy]
#[Layout('layouts.erp.layout-erp', ['anchoPantalla' => '100%'])]
#[Title('Seguimiento de Respuestas')]
class RespuestaLista extends Component
{
    use WithPagination;

    #[Url]
    public $auditoria_id = '';

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
        if (in_array($property, ['auditoria_id', 'estado_id', 'perPage', 'desde', 'hasta'])) {
            $this->resetPage();
        }
    }

    public function resetFiltros()
    {
        $this->reset(['auditoria_id', 'estado_id', 'desde', 'hasta']);
        $this->perPage = 20;
        $this->resetPage();
    }

    public function exportExcelFiltro()
    {
        // $this->authorize('respuesta.exportar-filtro');

        return Excel::download(
            new RespuestasExport(
                auditoria_id: $this->auditoria_id,
                estado_id: $this->estado_id,
                perPage: $this->perPage,
                page: $this->getPage(),
                desde: $this->desde,
                hasta: $this->hasta,
                todo: false
            ),
            'respuestas_filtradas_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function exportExcelTodo()
    {
        // $this->authorize('respuesta.exportar-todo');

        return Excel::download(
            new RespuestasExport(
                desde: $this->desde,
                hasta: $this->hasta,
                todo: true
            ),
            'respuestas_completas_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function render()
    {
        $items = Respuesta::with(['auditoria', 'pregunta.categoria', 'estado', 'creator'])
            ->when($this->auditoria_id, function ($query) {
                $query->where('auditoria_id', $this->auditoria_id);
            })
            ->when($this->estado_id, function ($query) {
                $query->where('estado_respuesta_id', $this->estado_id);
            })
            ->when($this->desde, fn ($q) => $q->whereDate('created_at', '>=', $this->desde))
            ->when($this->hasta, fn ($q) => $q->whereDate('created_at', '<=', $this->hasta))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.erp.respuesta.respuesta-lista', [
            'items' => $items,
            'auditorias' => Auditoria::orderBy('titulo')->get(),
            'estados' => EstadoRespuesta::where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
