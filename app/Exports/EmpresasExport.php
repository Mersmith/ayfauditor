<?php

namespace App\Exports;

use App\Models\Empresa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmpresasExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected ?string $buscar;

    protected ?string $activo;

    protected ?int $perPage;

    protected ?int $page;

    protected ?string $desde;

    protected ?string $hasta;

    protected bool $todo;

    public function __construct(
        ?string $buscar = null,
        ?string $activo = null,
        ?int $perPage = null,
        ?int $page = null,
        ?string $desde = null,
        ?string $hasta = null,
        bool $todo = false
    ) {
        $this->buscar = $buscar;
        $this->activo = $activo;
        $this->perPage = $perPage;
        $this->page = $page;
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->todo = $todo;
    }

    public function collection()
    {
        $query = Empresa::query()->with(['cliente', 'tipoDocumento']);

        if (! $this->todo) {
            $query->when($this->buscar, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('razon_social', 'like', "%{$this->buscar}%")
                        ->orWhere('nombre_comercial', 'like', "%{$this->buscar}%")
                        ->orWhere('numero_documento', 'like', "%{$this->buscar}%");

                    if (is_numeric($this->buscar)) {
                        $sub->orWhere('id', (int) $this->buscar);
                    }
                });
            })
                ->when($this->activo !== '', function ($q) {
                    $q->where('activo', $this->activo);
                });
        }

        $query->when($this->desde, fn ($q) => $q->whereDate('created_at', '>=', $this->desde))
            ->when($this->hasta, fn ($q) => $q->whereDate('created_at', '<=', $this->hasta))
            ->latest();

        if (! $this->todo && $this->perPage && $this->page) {
            $query->skip(($this->page - 1) * $this->perPage)->take($this->perPage);
        }

        return $query->get()->map(function ($item, $index) {
            return [
                $index + 1,
                $item->id,
                $item->razon_social,
                $item->nombre_comercial ?? '-',
                $item->tipoDocumento?->abreviatura.': '.$item->numero_documento,
                $item->cliente?->nombre ?? '-',
                $item->correo ?? '-',
                $item->telefono ?? '-',
                $item->activo ? 'Activo' : 'Inactivo',
                $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'N°',
            'ID',
            'Razón Social',
            'Nombre Comercial',
            'Documento',
            'Cliente',
            'Correo',
            'Teléfono',
            'Estado',
            'Fecha Registro',
        ];
    }
}
