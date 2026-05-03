<?php

namespace App\Livewire\Erp\Auditoria;

use App\Models\Auditoria;
use App\Models\Empresa;
use App\Models\EstadoAuditoria;
use App\Models\EstadoRespuesta;
use App\Models\Plantilla;
use App\Models\Respuesta;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Nueva Auditoría')]
class AuditoriaCrear extends Component
{
    public string $titulo = '';

    public ?int $empresa_id = null;

    public ?int $plantilla_id = null;

    public ?int $estado_auditoria_id = null;

    public ?string $fecha_inicio = null;

    public ?string $fecha_fin = null;

    protected $rules = [
        'titulo' => 'required|string|max:255',
        'empresa_id' => 'required|exists:empresas,id',
        'plantilla_id' => 'nullable|exists:plantillas,id',
        'estado_auditoria_id' => 'required|exists:estado_auditorias,id',
        'fecha_inicio' => 'nullable|date',
        'fecha_fin' => 'nullable|date',
    ];

    public function mount()
    {
        $this->estado_auditoria_id = EstadoAuditoria::first()?->id;
        $this->fecha_inicio = now()->format('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        $auditoria = Auditoria::create([
            'titulo' => $this->titulo,
            'empresa_id' => $this->empresa_id,
            'plantilla_id' => $this->plantilla_id,
            'estado_auditoria_id' => $this->estado_auditoria_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ]);

        // Si se seleccionó una plantilla, inicializar las respuestas
        if ($this->plantilla_id) {
            $plantilla = Plantilla::with('preguntas')->find($this->plantilla_id);
            $estadoRespuestaPendiente = EstadoRespuesta::first()?->id; // Ajustar según lógica real

            foreach ($plantilla->preguntas as $pregunta) {
                Respuesta::create([
                    'auditoria_id' => $auditoria->id,
                    'pregunta_id' => $pregunta->id,
                    'estado_respuesta_id' => $estadoRespuestaPendiente,
                ]);
            }
        }

        session()->flash('success', 'Sesión de auditoría creada correctamente.');

        return $this->redirect(route('erp.auditoria.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.auditoria.auditoria-crear', [
            'empresas' => Empresa::where('activo', true)->get(),
            'plantillas' => Plantilla::where('activo', true)->get(),
            'estados' => EstadoAuditoria::all(),
        ]);
    }
}
