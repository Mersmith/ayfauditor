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
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Editar Auditoría')]
class AuditoriaEditar extends Component
{
    public Auditoria $auditoria;

    public $empresa_id;

    public $plantilla_id;

    public $titulo;

    public $estado_auditoria_id;

    public $fecha_inicio;

    public $fecha_fin;

    public function mount($id)
    {
        $this->auditoria = Auditoria::findOrFail($id);
        $this->empresa_id = $this->auditoria->empresa_id;
        $this->plantilla_id = $this->auditoria->plantilla_id;
        $this->titulo = $this->auditoria->titulo;
        $this->estado_auditoria_id = $this->auditoria->estado_auditoria_id;
        $this->fecha_inicio = $this->auditoria->fecha_inicio;
        $this->fecha_fin = $this->auditoria->fecha_fin;
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

    public function update()
    {
        // $this->authorize('auditoria.editar');

        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', [
                'type' => 'warning',
                'title' => 'Datos Inválidos',
                'text' => 'Verifique los errores en los campos resaltados.',
            ]);
            throw $e;
        }

        try {
            DB::beginTransaction();

            $this->auditoria->update([
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
                'title' => '¡Actualizado!',
                'text' => 'La auditoría se ha actualizado correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-auditoria')->error('[AUDITORIA] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->auditoria->id,
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo actualizar la auditoría.',
            ]);
        }
    }

    #[On('eliminarAuditoriaOn')]
    public function eliminarAuditoriaOn()
    {
        // $this->authorize('auditoria.eliminar');

        try {
            DB::beginTransaction();
            $this->auditoria->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminada',
                'text' => 'La auditoría ha sido eliminada correctamente.',
            ]);

            return redirect()->route('erp.auditoria.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-auditoria')->error('[AUDITORIA] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->auditoria->id,
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo eliminar el registro.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.auditoria.auditoria-editar', [
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
