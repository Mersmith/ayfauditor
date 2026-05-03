<?php

namespace App\Exports;

use App\Models\ParticipanteAuditoria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParticipantesAuditoriaExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected ?string $auditoria_id;

    protected ?string $user_id;

    protected ?int $perPage;

    protected ?int $page;

    protected ?string $desde;

    protected ?string $hasta;

    protected bool $todo;

    public function __construct(
        ?string $auditoria_id = null,
        ?string $user_id = null,
        ?int $perPage = null,
        ?int $page = null,
        ?string $desde = null,
        ?string $hasta = null,
        bool $todo = false
    ) {
        $this->auditoria_id = $auditoria_id;
        $this->user_id = $user_id;
        $this->perPage = $perPage;
        $this->page = $page;
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->todo = $todo;
    }

    public function collection()
    {
        $query = ParticipanteAuditoria::with(['auditoria', 'user', 'cargo', 'invitadoPor']);

        if (! $this->todo) {
            $query->when($this->auditoria_id, function ($q) {
                $q->where('auditoria_id', $this->auditoria_id);
            })
                ->when($this->user_id, function ($q) {
                    $q->where('user_id', $this->user_id);
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
                $item->user->name ?? '-',
                $item->cargo->nombre ?? '-',
                $item->invitadoPor->name ?? 'Sistema',
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
            'Participante',
            'Cargo en Auditoría',
            'Invitado Por',
            'Fecha Registro',
        ];
    }
}
