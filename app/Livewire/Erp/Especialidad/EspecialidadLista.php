<?php

namespace App\Livewire\Erp\Especialidad;

use App\Exports\EspecialidadesExport;
use App\Models\Especialidad;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy]
#[Layout('layouts.erp.layout-erp', ['anchoPantalla' => '100%'])]
#[Title('Especialidades del Equipo')]
class EspecialidadLista extends Component
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
        // $this->authorize('especialidad.exportar-filtro');

        return Excel::download(
            new EspecialidadesExport(
                buscar: $this->buscar,
                activo: $this->activo,
                perPage: $this->perPage,
                page: $this->getPage(),
                desde: $this->desde,
                hasta: $this->hasta,
                todo: false
            ),
            'especialidades_filtradas_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function exportExcelTodo()
    {
        // $this->authorize('especialidad.exportar-todo');

        return Excel::download(
            new EspecialidadesExport(
                desde: $this->desde,
                hasta: $this->hasta,
                todo: true
            ),
            'especialidades_completas_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function render()
    {
        $items = Especialidad::query()
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

        return view('livewire.erp.especialidad.especialidad-lista', compact('items'));
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
