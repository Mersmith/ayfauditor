<?php

namespace App\Livewire\Erp\CategoriaPregunta;

use App\Models\CategoriaPregunta;
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
#[Title('Editar Categoría')]
class CategoriaPreguntaEditar extends Component
{
    public CategoriaPregunta $categoria;

    public $nombre;

    public $descripcion;

    public $color;

    public $icono;

    public $activo;

    public function mount($id)
    {
        $this->categoria = CategoriaPregunta::findOrFail($id);
        $this->nombre = $this->categoria->nombre;
        $this->descripcion = $this->categoria->descripcion;
        $this->color = $this->categoria->color ?? '#3b82f6';
        $this->icono = $this->categoria->icono ?? 'fa-solid fa-list-check';
        $this->activo = (bool) $this->categoria->activo;
    }

    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('categoria_preguntas', 'nombre')->ignore($this->categoria->id)->whereNull('deleted_at')],
            'descripcion' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'icono' => 'nullable|string|max:100',
            'activo' => 'required|boolean',
        ];
    }

    public function validationAttributes()
    {
        return [
            'nombre' => 'nombre de la categoría',
            'color' => 'color identificador',
            'icono' => 'icono',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        // $this->authorize('categoria-pregunta.editar');

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

            $this->categoria->update([
                'nombre' => trim($this->nombre),
                'descripcion' => trim($this->descripcion) ?: null,
                'color' => $this->color ?: null,
                'icono' => $this->icono ?: null,
                'activo' => $this->activo,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Actualizado!',
                'text' => 'La categoría se ha actualizado correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-categoria-pregunta')->error('[CATEGORIA_PREG] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->categoria->id,
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo actualizar la categoría.',
            ]);
        }
    }

    #[On('eliminarCategoriaOn')]
    public function eliminarCategoriaOn()
    {
        // $this->authorize('categoria-pregunta.eliminar');

        try {
            DB::beginTransaction();
            $this->categoria->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminada',
                'text' => 'La categoría ha sido eliminada correctamente.',
            ]);

            return redirect()->route('erp.categoria-pregunta.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-categoria-pregunta')->error('[CATEGORIA_PREG] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->categoria->id,
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
        return view('livewire.erp.categoria-pregunta.categoria-pregunta-editar');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
