<?php

namespace App\Exports;

use App\Models\Auditoria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AuditoriasExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected ?string $buscar;

    protected ?string $empresa_id;

    protected ?string $estado_id;

    protected ?int $perPage;

    protected ?int $page;

    protected ?string $desde;

    protected ?string $hasta;

    protected bool $todo;

    public function __construct(
        ?string $buscar = null,
        ?string $empresa_id = null,
        ?string $estado_id = null,
        ?int $perPage = null,
        ?int $page = null,
        ?string $desde = null,
        ?string $hasta = null,
        bool $todo = false
    ) {
        $this->buscar = $buscar;
        $this->empresa_id = $empresa_id;
        $this->estado_id = $estado_id;
        $this->perPage = $perPage;
        $this->page = $page;
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->todo = $todo;
    }

    public function collection()
    {
        $query = Auditoria::with(['empresa', 'plantilla', 'estado']);

        if (! $this->todo) {
            $query->when($this->buscar, function ($q) {
                $q->where('titulo', 'like', "%{$this->buscar}%");

                if (is_numeric($this->buscar)) {
                    $q->orWhere('id', (int) $this->buscar);
                }
            })
                ->when($this->empresa_id, function ($q) {
                    $q->where('empresa_id', $this->empresa_id);
                })
                ->when($this->estado_id, function ($q) {
                    $q->where('estado_auditoria_id', $this->estado_id);
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
                $item->titulo,
                $item->empresa->razon_social ?? '-',
                $item->plantilla->nombre ?? '-',
                $item->estado->nombre ?? '-',
                $item->fecha_inicio ?? '-',
                $item->fecha_fin ?? '-',
                $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'N°',
            'ID',
            'Título de la Auditoría',
            'Empresa Cliente',
            'Plantilla Utilizada',
            'Estado Actual',
            'Fecha Inicio',
            'Fecha Fin Estimada',
            'Fecha Registro',
        ];
    }
}
