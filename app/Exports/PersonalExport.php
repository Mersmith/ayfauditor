<?php

namespace App\Exports;

use App\Models\Personal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonalExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected ?string $buscar;

    protected ?string $activo;

    protected ?int $perPage;

    protected ?int $page;

    protected ?string $desde;

    protected ?string $hasta;

    protected ?int $empresa_id;

    protected ?int $cargo_id;

    protected bool $todo;

    public function __construct(
        ?string $buscar = null,
        ?string $activo = null,
        ?int $perPage = null,
        ?int $page = null,
        ?string $desde = null,
        ?string $hasta = null,
        ?int $empresa_id = null,
        ?int $cargo_id = null,
        bool $todo = false
    ) {
        $this->buscar = $buscar;
        $this->activo = $activo;
        $this->perPage = $perPage;
        $this->page = $page;
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->empresa_id = $empresa_id;
        $this->cargo_id = $cargo_id;
        $this->todo = $todo;
    }

    public function collection()
    {
        $query = Personal::query()->with(['user', 'personalEmpresas.empresa', 'personalEmpresas.cargo']);

        if (! $this->todo) {
            $query->when($this->buscar, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nombre', 'like', "%{$this->buscar}%")
                        ->orWhere('dni', 'like', "%{$this->buscar}%")
                        ->orWhere('celular', 'like', "%{$this->buscar}%")
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
                ->when($this->empresa_id, function ($q) {
                    $q->whereHas('personalEmpresas', fn ($sub) => $sub->where('empresa_id', $this->empresa_id));
                })
                ->when($this->cargo_id, function ($q) {
                    $q->whereHas('personalEmpresas', fn ($sub) => $sub->where('cargo_id', $this->cargo_id));
                });
        }

        $query->when($this->desde, fn ($q) => $q->whereDate('created_at', '>=', $this->desde))
            ->when($this->hasta, fn ($q) => $q->whereDate('created_at', '<=', $this->hasta))
            ->latest();

        if (! $this->todo && $this->perPage && $this->page) {
            $query->skip(($this->page - 1) * $this->perPage)->take($this->perPage);
        }

        return $query->get()->map(function ($item, $index) {
            $empresasCargos = $item->personalEmpresas->map(function ($pe) {
                return ($pe->empresa?->razon_social ?? 'N/A').' ('.($pe->cargo?->nombre ?? 'S/C').')';
            })->implode(' | ');

            return [
                $index + 1,
                $item->id,
                $item->nombre,
                $item->dni ?? '-',
                $item->celular ?? '-',
                $item->user?->email ?? '-',
                $empresasCargos,
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
            'Celular',
            'Email de Acceso',
            'Empresas y Cargos',
            'Estado',
            'Fecha Registro',
        ];
    }
}
