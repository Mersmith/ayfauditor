<?php

namespace App\Livewire\Erp\Personal;

use App\Exports\PersonalExport;
use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\Personal;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy]
#[Layout('layouts.erp.layout-erp', ['anchoPantalla' => '100%'])]
#[Title('Personal de Empresas')]
class PersonalLista extends Component
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
    public $empresa_id = '';

    #[Url]
    public $cargo_id = '';

    public function updated($property)
    {
        if (in_array($property, ['buscar', 'activo', 'perPage', 'desde', 'hasta', 'empresa_id', 'cargo_id'])) {
            $this->resetPage();
        }
    }

    public function resetFiltros()
    {
        $this->reset(['buscar', 'activo', 'desde', 'hasta', 'empresa_id', 'cargo_id']);
        $this->perPage = 20;
        $this->resetPage();
    }

    public function exportExcelFiltro()
    {
        // $this->authorize('personal.exportar-filtro');

        return Excel::download(
            new PersonalExport(
                buscar: $this->buscar,
                activo: $this->activo,
                perPage: $this->perPage,
                page: $this->getPage(),
                desde: $this->desde,
                hasta: $this->hasta,
                empresa_id: $this->empresa_id ?: null,
                cargo_id: $this->cargo_id ?: null,
                todo: false
            ),
            'personal_filtrado_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function exportExcelTodo()
    {
        // $this->authorize('personal.exportar-todo');

        return Excel::download(
            new PersonalExport(
                desde: $this->desde,
                hasta: $this->hasta,
                empresa_id: $this->empresa_id ?: null,
                cargo_id: $this->cargo_id ?: null,
                todo: true
            ),
            'personal_completo_'.now()->format('Y-m-d_H-i').'.xlsx'
        );
    }

    public function render()
    {
        $items = Personal::query()
            ->with(['user', 'personalEmpresas.empresa', 'personalEmpresas.cargo'])
            ->when($this->buscar, function ($query) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', "%{$this->buscar}%")
                        ->orWhere('dni', 'like', "%{$this->buscar}%")
                        ->orWhere('celular', 'like', "%{$this->buscar}%")
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
            ->when($this->empresa_id, function ($query) {
                $query->whereHas('personalEmpresas', fn ($q) => $q->where('empresa_id', $this->empresa_id));
            })
            ->when($this->cargo_id, function ($query) {
                $query->whereHas('personalEmpresas', fn ($q) => $q->where('cargo_id', $this->cargo_id));
            })
            ->when($this->desde, fn ($q) => $q->whereDate('created_at', '>=', $this->desde))
            ->when($this->hasta, fn ($q) => $q->whereDate('created_at', '<=', $this->hasta))
            ->latest()
            ->paginate($this->perPage);

        $empresas = Empresa::where('activo', true)->orderBy('razon_social')->get();
        $cargos = Cargo::where('activo', true)->orderBy('nombre')->get();

        return view('livewire.erp.personal.personal-lista', compact('items', 'empresas', 'cargos'));
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
