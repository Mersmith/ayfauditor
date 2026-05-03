<?php

namespace App\Livewire\Erp\EstadoAuditoria;

use App\Models\EstadoAuditoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Editar Estado de Auditoría')]
class EstadoAuditoriaEditar extends Component
{
    public EstadoAuditoria $estadoAuditoria;

    public $nombre;

    public $color;

    public $icono;

    public $descripcion;

    public $activo;

    public function mount($id)
    {
        $this->estadoAuditoria = EstadoAuditoria::findOrFail($id);
        $this->nombre = $this->estadoAuditoria->nombre;
        $this->color = $this->estadoAuditoria->color;
        $this->icono = $this->estadoAuditoria->icono;
        $this->descripcion = $this->estadoAuditoria->descripcion;
        $this->activo = (bool) $this->estadoAuditoria->activo;
    }

    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('estado_auditorias', 'nombre')->ignore($this->estadoAuditoria->id)->whereNull('deleted_at')],
            'color' => 'nullable|string|max:20',
            'icono' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string',
            'activo' => 'required|boolean',
        ];
    }

    public function validationAttributes()
    {
        return [
            'nombre' => 'nombre del estado',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        // $this->authorize('estado-auditoria.editar');

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

            $this->estadoAuditoria->update([
                'nombre' => trim($this->nombre),
                'color' => $this->color,
                'icono' => $this->icono,
                'descripcion' => trim($this->descripcion) ?: null,
                'activo' => $this->activo,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Actualizado!',
                'text' => 'El estado se ha actualizado correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-estado-auditoria')->error('[ESTADO AUDITORIA] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->estadoAuditoria->id,
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo actualizar el estado.',
            ]);
        }
    }

    #[On('eliminarEstadoAuditoriaOn')]
    public function eliminarEstadoAuditoriaOn()
    {
        // $this->authorize('estado-auditoria.eliminar');

        try {
            DB::beginTransaction();
            $this->estadoAuditoria->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminado',
                'text' => 'El estado ha sido eliminado correctamente.',
            ]);

            return redirect()->route('erp.estado-auditoria.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-estado-auditoria')->error('[ESTADO AUDITORIA] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->estadoAuditoria->id,
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
        return view('livewire.erp.estado-auditoria.estado-auditoria-editar');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
