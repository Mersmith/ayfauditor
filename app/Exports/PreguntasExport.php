<?php

namespace App\Exports;

use App\Models\Pregunta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PreguntasExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected ?string $buscar;

    protected ?string $activo;

    protected ?string $categoria_id;

    protected ?int $perPage;

    protected ?int $page;

    protected ?string $desde;

    protected ?string $hasta;

    protected bool $todo;

    public function __construct(
        ?string $buscar = null,
        ?string $activo = null,
        ?string $categoria_id = null,
        ?int $perPage = null,
        ?int $page = null,
        ?string $desde = null,
        ?string $hasta = null,
        bool $todo = false
    ) {
        $this->buscar = $buscar;
        $this->activo = $activo;
        $this->categoria_id = $categoria_id;
        $this->perPage = $perPage;
        $this->page = $page;
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->todo = $todo;
    }

    public function collection()
    {
        $query = Pregunta::with('categoria');

        if (! $this->todo) {
            $query->when($this->buscar, function ($q) {
                $q->where('texto', 'like', "%{$this->buscar}%");

                if (is_numeric($this->buscar)) {
                    $q->orWhere('id', (int) $this->buscar);
                }
            })
                ->when($this->activo !== '', function ($q) {
                    $q->where('activo', $this->activo);
                })
                ->when($this->categoria_id, function ($q) {
                    $q->where('categoria_pregunta_id', $this->categoria_id);
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
                $item->orden_sugerido ?? '-',
                $item->texto,
                $item->categoria->nombre ?? '-',
                $item->descripcion_ayuda ?? '-',
                $item->activo ? 'Activa' : 'Inactiva',
                $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'N°',
            'ID',
            'Orden Sugerido',
            'Pregunta',
            'Categoría',
            'Ayuda',
            'Estado',
            'Fecha Registro',
        ];
    }
}
