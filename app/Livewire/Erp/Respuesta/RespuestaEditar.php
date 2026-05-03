<?php

namespace App\Livewire\Erp\Respuesta;

use App\Models\ComentarioRespuesta;
use App\Models\EstadoRespuesta;
use App\Models\Respuesta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Lazy]
#[Layout('layouts.erp.layout-erp', ['anchoPantalla' => '100%'])]
#[Title('Calificar Respuesta')]
class RespuestaEditar extends Component
{
    use WithFileUploads;

    public Respuesta $respuesta;

    // Campos editables
    public $respuesta_cliente;

    public $estado_respuesta_id;

    public $nuevo_comentario;

    // Catálogos
    public $mapEstados = [];

    protected function rules()
    {
        return [
            'respuesta_cliente' => 'nullable|string',
            'estado_respuesta_id' => 'required|exists:estado_respuestas,id',
            'nuevo_comentario' => 'nullable|string|max:1000',
        ];
    }

    public function mount($id)
    {
        $this->respuesta = Respuesta::with(['auditoria', 'pregunta.categoria', 'estado', 'comentarios.user', 'creator'])->findOrFail($id);

        $this->respuesta_cliente = $this->respuesta->respuesta_cliente;
        $this->estado_respuesta_id = $this->respuesta->estado_respuesta_id;

        $this->mapEstados = EstadoRespuesta::where('activo', true)->pluck('nombre', 'id')->toArray();
    }

    public function validationAttributes()
    {
        return [
            'respuesta_cliente' => 'respuesta del cliente',
            'estado_respuesta_id' => 'estado de calificación',
            'nuevo_comentario' => 'comentario de auditoría',
        ];
    }

    public function update()
    {
        // $this->authorize('respuesta.editar');

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

            $old = $this->respuesta->fresh();
            $cambios = [];

            if ($this->estado_respuesta_id != $old->estado_respuesta_id) {
                $viejo = $this->mapEstados[$old->estado_respuesta_id] ?? 'N/A';
                $nuevo = $this->mapEstados[$this->estado_respuesta_id] ?? 'N/A';
                $cambios[] = "Estado de calificación cambiado de '$viejo' a '$nuevo'";
            }

            if (trim($this->respuesta_cliente ?? '') !== trim($old->respuesta_cliente ?? '')) {
                $cambios[] = 'Contenido de respuesta actualizado';
            }

            $this->respuesta->update([
                'respuesta_cliente' => $this->respuesta_cliente,
                'estado_respuesta_id' => $this->estado_respuesta_id,
                'updated_by' => auth()->id(),
            ]);

            // Si hay un nuevo comentario, registrarlo
            if (trim($this->nuevo_comentario)) {
                ComentarioRespuesta::create([
                    'respuesta_id' => $this->respuesta->id,
                    'user_id' => auth()->id(),
                    'comentario' => trim($this->nuevo_comentario),
                ]);
                $this->reset('nuevo_comentario');
                $this->respuesta->load('comentarios.user');
            }

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Actualizado!',
                'text' => 'Calificación guardada correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-respuesta')->error('[RESPUESTA] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->respuesta->id,
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo guardar la calificación.',
            ]);
        }
    }

    #[On('eliminarRespuestaOn')]
    public function eliminarRespuestaOn()
    {
        // $this->authorize('respuesta.eliminar');

        try {
            DB::beginTransaction();
            $this->respuesta->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminada',
                'text' => 'La respuesta ha sido eliminada correctamente.',
            ]);

            return redirect()->route('erp.respuesta.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-respuesta')->error('[RESPUESTA] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->respuesta->id,
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
        return view('livewire.erp.respuesta.respuesta-editar', [
            'estados' => EstadoRespuesta::where('activo', true)->get(),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
