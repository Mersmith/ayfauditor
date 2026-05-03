<?php

namespace App\Exports;

use App\Models\Trabajador;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TrabajadoresExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected ?string $buscar;

    protected ?string $activo;

    protected ?int $perPage;

    protected ?int $page;

    protected ?string $desde;

    protected ?string $hasta;

    protected ?int $especialidad_id;

    protected ?int $cargo_id;

    protected bool $todo;

    public function __construct(
        ?string $buscar = null,
        ?string $activo = null,
        ?int $perPage = null,
        ?int $page = null,
        ?string $desde = null,
        ?string $hasta = null,
        ?int $especialidad_id = null,
        ?int $cargo_id = null,
        bool $todo = false
    ) {
        $this->buscar = $buscar;
        $this->activo = $activo;
        $this->perPage = $perPage;
        $this->page = $page;
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->especialidad_id = $especialidad_id;
        $this->cargo_id = $cargo_id;
        $this->todo = $todo;
    }

    public function collection()
    {
        $query = Trabajador::query()->with(['user', 'especialidad', 'cargo']);

        if (! $this->todo) {
            $query->when($this->buscar, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nombre', 'like', "%{$this->buscar}%")
                        ->orWhere('dni', 'like', "%{$this->buscar}%")
                        ->orWhereHas('user', function ($qu) {
                            $qu->where('email', 'like', "%{$this->buscar}%");
                        });

                    if (is_numeric($this->buscar)) {
                        $sub->orWhere('id', (int) $this->buscar);
                    }
                });
            })
                ->when($this->activo !== '', function ($q) {
                    $q->where('activo', $this->activo);
                })
                ->when($this->especialidad_id, function ($q) {
                    $q->where('especialidad_id', $this->especialidad_id);
                })
                ->when($this->cargo_id, function ($q) {
                    $q->where('cargo_id', $this->cargo_id);
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
                $item->nombre,
                $item->dni ?? '-',
                $item->user?->email ?? '-',
                $item->especialidad?->nombre ?? 'N/A',
                $item->cargo?->nombre ?? 'N/A',
                $item->registro_profesional ?? '-',
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
            'Nombre Completo',
            'DNI',
            'Email Acceso',
            'Especialidad',
            'Cargo',
            'Reg. Profesional',
            'Estado',
            'Fecha Registro',
        ];
    }
}
