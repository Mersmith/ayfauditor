<?php

namespace App\Livewire\Erp\Pregunta;

use App\Exports\PreguntasExport;
use App\Models\CategoriaPregunta;
use App\Models\Pregunta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy]
#[Layout('layouts.erp.layout-erp', ['anchoPantalla' => '100%'])]
#[Title('Banco de Preguntas')]
class PreguntaLista extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $buscar = '';

    #[Url]
    public $activo = '';

    #[Url]
    public $categoria_id = '';

    #[Url]
    public $perPage = 20;

    #[Url]
    public $desde = '';

    #[Url]
    public $hasta = '';

    public function updated($property)
    {
        if (in_array($property, ['buscar', 'activo', 'categoria_id', 'perPage', 'desde', 'hasta'])) {
            $this->resetPage();
        }
    }

    public function resetFiltros()
    {
        $this->reset(['buscar', 'activo', 'categoria_id', 'desde', 'hasta']);
        $this->perPage = 20;
        $this->resetPage();
    }

    public function exportExcelFiltro()
    {
        // $this->authorize('pregunta.exportar-filtro');

        return Excel::download(
            new PreguntasExport(
                buscar: $this->buscar,
                activo: $this->activo,
                categoria_id: $this->categoria_id,
                perPage: $this->perPage,
                page: $this->getPage(),
                desde: $this->desde,
                hasta: $this->hasta,
                todo: false
            ),
            'preguntas_filtradas_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function exportExcelTodo()
    {
        // $this->authorize('pregunta.exportar-todo');

        return Excel::download(
            new PreguntasExport(
                desde: $this->desde,
                hasta: $this->hasta,
                todo: true
            ),
            'preguntas_completas_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function render()
    {
        $items = Pregunta::with('categoria')
            ->when($this->buscar, function ($query) {
                $query->where('texto', 'like', "%{$this->buscar}%");

                if (is_numeric($this->buscar)) {
                    $query->orWhere('id', (int) $this->buscar);
                }
            })
            ->when($this->activo !== '', function ($query) {
                $query->where('activo', $this->activo);
            })
            ->when($this->categoria_id, function ($query) {
                $query->where('categoria_pregunta_id', $this->categoria_id);
            })
            ->when($this->desde, fn ($q) => $q->whereDate('created_at', '>=', $this->desde))
            ->when($this->hasta, fn ($q) => $q->whereDate('created_at', '<=', $this->hasta))
            ->orderBy('categoria_pregunta_id')
            ->orderBy('orden_sugerido')
            ->paginate($this->perPage);

        return view('livewire.erp.pregunta.pregunta-lista', [
            'items' => $items,
            'categorias' => CategoriaPregunta::where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
