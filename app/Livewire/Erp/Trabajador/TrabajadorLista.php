<?php

namespace App\Livewire\Erp\Trabajador;

use App\Exports\TrabajadoresExport;
use App\Models\Cargo;
use App\Models\Especialidad;
use App\Models\Trabajador;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy]
#[Layout('layouts.erp.layout-erp', ['anchoPantalla' => '100%'])]
#[Title('Trabajadores Internos')]
class TrabajadorLista extends Component
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

    #[Url]
    public $especialidad_id = '';

    #[Url]
    public $cargo_id = '';

    public function updated($property)
    {
        if (in_array($property, ['buscar', 'activo', 'perPage', 'desde', 'hasta', 'especialidad_id', 'cargo_id'])) {
            $this->resetPage();
        }
    }

    public function resetFiltros()
    {
        $this->reset(['buscar', 'activo', 'desde', 'hasta', 'especialidad_id', 'cargo_id']);
        $this->perPage = 20;
        $this->resetPage();
    }

    public function exportExcelFiltro()
    {
        // $this->authorize('trabajador.exportar-filtro');

        return Excel::download(
            new TrabajadoresExport(
                buscar: $this->buscar,
                activo: $this->activo,
                perPage: $this->perPage,
                page: $this->getPage(),
                desde: $this->desde,
                hasta: $this->hasta,
                especialidad_id: $this->especialidad_id ?: null,
                cargo_id: $this->cargo_id ?: null,
                todo: false
            ),
            'trabajadores_filtrados_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function exportExcelTodo()
    {
        // $this->authorize('trabajador.exportar-todo');

        return Excel::download(
            new TrabajadoresExport(
                desde: $this->desde,
                hasta: $this->hasta,
                especialidad_id: $this->especialidad_id ?: null,
                cargo_id: $this->cargo_id ?: null,
                todo: true
            ),
            'trabajadores_completos_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function render()
    {
        $items = Trabajador::query()
            ->with(['user', 'especialidad', 'cargo'])
            ->when($this->buscar, function ($query) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', "%{$this->buscar}%")
                        ->orWhere('dni', 'like', "%{$this->buscar}%")
                        ->orWhereHas('user', function ($qu) {
                            $qu->where('email', 'like', "%{$this->buscar}%");
                        });

                    if (is_numeric($this->buscar)) {
                        $q->orWhere('id', (int) $this->buscar);
                    }
                });
            })
            ->when($this->activo !== '', function ($query) {
                $query->where('activo', $this->activo);
            })
            ->when($this->especialidad_id, function ($query) {
                $query->where('especialidad_id', $this->especialidad_id);
            })
            ->when($this->cargo_id, function ($query) {
                $query->where('cargo_id', $this->cargo_id);
            })
            ->when($this->desde, fn ($q) => $q->whereDate('created_at', '>=', $this->desde))
            ->when($this->hasta, fn ($q) => $q->whereDate('created_at', '<=', $this->hasta))
            ->latest()
            ->paginate($this->perPage);

        $especialidades = Especialidad::where('activo', true)->orderBy('nombre')->get();
        $cargos = Cargo::where('activo', true)->orderBy('nombre')->get();

        return view('livewire.erp.trabajador.trabajador-lista', compact('items', 'especialidades', 'cargos'));
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
