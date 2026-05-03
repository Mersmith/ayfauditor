<?php

namespace App\Livewire\Erp\EstadoRespuesta;

use App\Models\EstadoRespuesta;
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
#[Title('Editar Estado de Respuesta')]
class EstadoRespuestaEditar extends Component
{
    public EstadoRespuesta $estadoRespuesta;

    public $nombre;

    public $color;

    public $icono;

    public $descripcion;

    public $activo;

    public function mount($id)
    {
        $this->estadoRespuesta = EstadoRespuesta::findOrFail($id);
        $this->nombre = $this->estadoRespuesta->nombre;
        $this->color = $this->estadoRespuesta->color;
        $this->icono = $this->estadoRespuesta->icono;
        $this->descripcion = $this->estadoRespuesta->descripcion;
        $this->activo = (bool) $this->estadoRespuesta->activo;
    }

    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('estado_respuestas', 'nombre')->ignore($this->estadoRespuesta->id)->whereNull('deleted_at')],
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
        // $this->authorize('estado-respuesta.editar');

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

            $this->estadoRespuesta->update([
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
            Log::channel('erp-estado-respuesta')->error('[ESTADO RESPUESTA] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->estadoRespuesta->id,
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

    #[On('eliminarEstadoRespuestaOn')]
    public function eliminarEstadoRespuestaOn()
    {
        // $this->authorize('estado-respuesta.eliminar');

        try {
            DB::beginTransaction();
            $this->estadoRespuesta->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminado',
                'text' => 'El estado ha sido eliminado correctamente.',
            ]);

            return redirect()->route('erp.estado-respuesta.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-estado-respuesta')->error('[ESTADO RESPUESTA] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->estadoRespuesta->id,
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
        return view('livewire.erp.estado-respuesta.estado-respuesta-editar');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
