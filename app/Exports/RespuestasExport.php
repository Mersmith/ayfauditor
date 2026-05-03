<?php

namespace App\Exports;

use App\Models\Respuesta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RespuestasExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected ?string $auditoria_id;

    protected ?string $estado_id;

    protected ?int $perPage;

    protected ?int $page;

    protected ?string $desde;

    protected ?string $hasta;

    protected bool $todo;

    public function __construct(
        ?string $auditoria_id = null,
        ?string $estado_id = null,
        ?int $perPage = null,
        ?int $page = null,
        ?string $desde = null,
        ?string $hasta = null,
        bool $todo = false
    ) {
        $this->auditoria_id = $auditoria_id;
        $this->estado_id = $estado_id;
        $this->perPage = $perPage;
        $this->page = $page;
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->todo = $todo;
    }

    public function collection()
    {
        $query = Respuesta::with(['auditoria', 'pregunta', 'estado', 'creator']);

        if (! $this->todo) {
            $query->when($this->auditoria_id, function ($q) {
                $q->where('auditoria_id', $this->auditoria_id);
            })
                ->when($this->estado_id, function ($q) {
                    $q->where('estado_respuesta_id', $this->estado_id);
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
                $item->auditoria->titulo ?? '-',
                $item->pregunta->texto ?? '-',
                $item->respuesta_cliente ?? '-',
                $item->estado->nombre ?? '-',
                $item->creator->name ?? 'Sistema',
                $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'N°',
            'ID',
            'Auditoria',
            'Pregunta',
            'Respuesta del Cliente',
            'Estado',
            'Registrado Por',
            'Fecha Registro',
        ];
    }
}
