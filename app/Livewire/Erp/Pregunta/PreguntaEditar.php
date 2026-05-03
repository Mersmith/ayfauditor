<?php

namespace App\Livewire\Erp\Pregunta;

use App\Models\CategoriaPregunta;
use App\Models\Pregunta;
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
#[Title('Editar Pregunta')]
class PreguntaEditar extends Component
{
    public Pregunta $pregunta;

    public $texto;

    public $categoria_pregunta_id;

    public $orden_sugerido;

    public $descripcion_ayuda;

    public $activo;

    public function mount($id)
    {
        $this->pregunta = Pregunta::findOrFail($id);
        $this->texto = $this->pregunta->texto;
        $this->categoria_pregunta_id = $this->pregunta->categoria_pregunta_id;
        $this->orden_sugerido = $this->pregunta->orden_sugerido;
        $this->descripcion_ayuda = $this->pregunta->descripcion_ayuda;
        $this->activo = (bool) $this->pregunta->activo;
    }

    protected function rules()
    {
        return [
            'texto' => ['required', 'string', 'max:1000', Rule::unique('preguntas', 'texto')->ignore($this->pregunta->id)->whereNull('deleted_at')],
            'categoria_pregunta_id' => 'required|exists:categoria_preguntas,id',
            'orden_sugerido' => 'nullable|integer|min:0',
            'descripcion_ayuda' => 'nullable|string|max:2000',
            'activo' => 'required|boolean',
        ];
    }

    public function validationAttributes()
    {
        return [
            'texto' => 'enunciado de la pregunta',
            'categoria_pregunta_id' => 'categoría',
            'orden_sugerido' => 'orden sugerido',
            'descripcion_ayuda' => 'descripción de ayuda',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        // $this->authorize('pregunta.editar');

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

            $this->pregunta->update([
                'texto' => trim($this->texto),
                'categoria_pregunta_id' => $this->categoria_pregunta_id,
                'orden_sugerido' => $this->orden_sugerido ?: 0,
                'descripcion_ayuda' => trim($this->descripcion_ayuda) ?: null,
                'activo' => $this->activo,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Actualizado!',
                'text' => 'La pregunta se ha actualizado correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-pregunta')->error('[PREGUNTA] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->pregunta->id,
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo actualizar la pregunta.',
            ]);
        }
    }

    #[On('eliminarPreguntaOn')]
    public function eliminarPreguntaOn()
    {
        // $this->authorize('pregunta.eliminar');

        try {
            DB::beginTransaction();
            $this->pregunta->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminada',
                'text' => 'La pregunta ha sido eliminada correctamente.',
            ]);

            return redirect()->route('erp.pregunta.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-pregunta')->error('[PREGUNTA] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->pregunta->id,
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
        return view('livewire.erp.pregunta.pregunta-editar', [
            'categorias' => CategoriaPregunta::where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
