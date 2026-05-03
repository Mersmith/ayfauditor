<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientesExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected ?string $buscar;

    protected ?string $activo;

    protected ?int $perPage;

    protected ?int $page;

    protected bool $todo;

    public function __construct(
        ?string $buscar = null,
        ?string $activo = null,
        ?int $perPage = null,
        ?int $page = null,
        bool $todo = false
    ) {
        $this->buscar = $buscar;
        $this->activo = $activo;
        $this->perPage = $perPage;
        $this->page = $page;
        $this->todo = $todo;
    }

    public function collection()
    {
        $query = Cliente::query()
            ->with('user');

        if (! $this->todo) {
            $query->when($this->buscar !== '', function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nombre', 'like', "%{$this->buscar}%")
                        ->orWhere('dni', 'like', "%{$this->buscar}%")
                        ->orWhere('celular', 'like', "%{$this->buscar}%");
                });
            })
                ->when($this->activo !== '', fn ($q) => $q->where('activo', $this->activo));
        }

        $query->latest();

        if (! $this->todo && $this->perPage && $this->page) {
            $query->skip(($this->page - 1) * $this->perPage)->take($this->perPage);
        }

        return $query->get()->map(function ($c, $index) {
            return [
                $index + 1,
                $c->id,
                $c->nombre,
                $c->dni ?? '-',
                $c->celular ?? '-',
                $c->user ? $c->user->email : '-',
                $c->activo ? 'Activo' : 'Inactivo',
                $c->created_at ? $c->created_at->format('Y-m-d H:i') : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'N°',
            'ID',
            'Nombre',
            'DNI',
            'Celular',
            'Email (Login)',
            'Estado',
            'Fecha Registro',
        ];
    }
}
