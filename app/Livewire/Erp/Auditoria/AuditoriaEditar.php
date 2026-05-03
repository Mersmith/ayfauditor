<?php

namespace App\Livewire\Erp\Auditoria;

use App\Models\Auditoria;
use App\Models\Empresa;
use App\Models\EstadoAuditoria;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Auditoría')]
class AuditoriaEditar extends Component
{
    public Auditoria $auditoria;

    public string $titulo = '';

    public ?int $empresa_id = null;

    public ?int $plantilla_id = null;

    public ?int $estado_auditoria_id = null;

    public ?string $fecha_inicio = null;

    public ?string $fecha_fin = null;

    public function mount($id)
    {
        $this->auditoria = Auditoria::findOrFail($id);
        $this->titulo = $this->auditoria->titulo;
        $this->empresa_id = $this->auditoria->empresa_id;
        $this->plantilla_id = $this->auditoria->plantilla_id;
        $this->estado_auditoria_id = $this->auditoria->estado_auditoria_id;
        $this->fecha_inicio = $this->auditoria->fecha_inicio ? $this->auditoria->fecha_inicio : null;
        $this->fecha_fin = $this->auditoria->fecha_fin ? $this->auditoria->fecha_fin : null;
    }

    protected $rules = [
        'titulo' => 'required|string|max:255',
        'empresa_id' => 'required|exists:empresas,id',
        'estado_auditoria_id' => 'required|exists:estado_auditorias,id',
        'fecha_inicio' => 'nullable|date',
        'fecha_fin' => 'nullable|date',
    ];

    public function update()
    {
        $this->validate();

        $this->auditoria->update([
            'titulo' => $this->titulo,
            'empresa_id' => $this->empresa_id,
            'estado_auditoria_id' => $this->estado_auditoria_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ]);

        session()->flash('success', 'Auditoría actualizada correctamente.');

        return $this->redirect(route('erp.auditoria.vista.lista'), navigate: true);
    }

    public function delete()
    {
        $this->auditoria->delete();
        session()->flash('success', 'Auditoría eliminada.');

        return $this->redirect(route('erp.auditoria.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.auditoria.auditoria-editar', [
            'empresas' => Empresa::where('activo', true)->get(),
            'estados' => EstadoAuditoria::all(),
        ]);
    }
}
