<?php

namespace App\Livewire\Erp\Empresa;

use App\Exports\EmpresasExport;
use App\Models\Empresa;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy]
#[Layout('layouts.erp.layout-erp', ['anchoPantalla' => '100%'])]
#[Title('Empresas')]
class EmpresaLista extends Component
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
        // $this->authorize('empresa.exportar-filtro');

        return Excel::download(
            new EmpresasExport(
                buscar: $this->buscar,
                activo: $this->activo,
                perPage: $this->perPage,
                page: $this->getPage(),
                desde: $this->desde,
                hasta: $this->hasta,
                todo: false
            ),
            'empresas_filtradas_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function exportExcelTodo()
    {
        // $this->authorize('empresa.exportar-todo');

        return Excel::download(
            new EmpresasExport(
                desde: $this->desde,
                hasta: $this->hasta,
                todo: true
            ),
            'empresas_completas_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function render()
    {
        $items = Empresa::query()
            ->with(['cliente', 'tipoDocumento'])
            ->when($this->buscar, function ($query) {
                $query->where(function ($q) {
                    $q->where('razon_social', 'like', "%{$this->buscar}%")
                        ->orWhere('nombre_comercial', 'like', "%{$this->buscar}%")
                        ->orWhere('numero_documento', 'like', "%{$this->buscar}%");

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

        return view('livewire.erp.empresa.empresa-lista', compact('items'));
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
