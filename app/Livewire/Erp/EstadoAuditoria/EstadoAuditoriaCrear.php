<?php

namespace App\Livewire\Erp\EstadoAuditoria;

use App\Models\EstadoAuditoria;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Crear Estado de Auditoría')]
class EstadoAuditoriaCrear extends Component
{
    public string $nombre = '';

    public string $descripcion = '';

    public string $color = '';

    public string $icono = '';

    public bool $activo = true;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'color' => 'nullable|string|max:50',
        'icono' => 'nullable|string|max:100',
        'activo' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        EstadoAuditoria::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'color' => $this->color,
            'icono' => $this->icono,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Estado creado correctamente.');

        return $this->redirect(route('erp.estado-auditoria.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.estado-auditoria.estado-auditoria-crear');
    }
}
