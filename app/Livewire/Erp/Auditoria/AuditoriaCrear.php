<?php

namespace App\Livewire\Erp\Auditoria;

use App\Models\Auditoria;
use App\Models\Empresa;
use App\Models\EstadoAuditoria;
use App\Models\Plantilla;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Programar Auditoría')]
class AuditoriaCrear extends Component
{
    public $empresa_id = '';

    public $plantilla_id = '';

    public $titulo = '';

    public $estado_auditoria_id = '';

    public $fecha_inicio;

    public $fecha_fin;

    public function mount()
    {
        $this->fecha_inicio = now()->format('Y-m-d');
        // Por defecto el primer estado activo
        $primerEstado = EstadoAuditoria::where('activo', true)->orderBy('id')->first();
        $this->estado_auditoria_id = $primerEstado ? $primerEstado->id : '';
    }

    protected function rules()
    {
        return [
            'empresa_id' => 'required|exists:empresas,id',
            'plantilla_id' => 'required|exists:plantillas,id',
            'titulo' => 'required|string|max:255',
            'estado_auditoria_id' => 'required|exists:estado_auditorias,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ];
    }

    public function validationAttributes()
    {
        return [
            'empresa_id' => 'empresa',
            'plantilla_id' => 'plantilla',
            'titulo' => 'título de la auditoría',
            'estado_auditoria_id' => 'estado',
            'fecha_inicio' => 'fecha de inicio',
            'fecha_fin' => 'fecha de fin',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        // $this->authorize('auditoria.crear');

        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', [
                'type' => 'warning',
                'title' => 'Datos Incompletos',
                'text' => 'Verifique los errores en los campos resaltados.',
            ]);
            throw $e;
        }

        try {
            DB::beginTransaction();

            $auditoria = Auditoria::create([
                'empresa_id' => $this->empresa_id,
                'plantilla_id' => $this->plantilla_id,
                'titulo' => trim($this->titulo),
                'estado_auditoria_id' => $this->estado_auditoria_id,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin ?: null,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => 'La auditoría se ha programado correctamente.',
            ]);

            return redirect()->route('erp.auditoria.vista.lista');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-auditoria')->error('[AUDITORIA] Error al crear: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo programar la auditoría. Intente nuevamente.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.auditoria.auditoria-crear', [
            'empresas' => Empresa::where('activo', true)->orderBy('razon_social')->get(),
            'plantillas' => Plantilla::where('activo', true)->orderBy('nombre')->get(),
            'estados' => EstadoAuditoria::where('activo', true)->orderBy('id')->get(),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
