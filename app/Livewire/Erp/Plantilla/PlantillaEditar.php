<?php

namespace App\Livewire\Erp\Plantilla;

use App\Models\Plantilla;
use App\Models\Pregunta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
#[Layout('layouts.erp.layout-erp', ['anchoPantalla' => '100%'])]
#[Title('Configurar Plantilla')]
class PlantillaEditar extends Component
{
    use WithPagination;

    public Plantilla $plantilla;

    public $nombre;

    public $descripcion;

    public $activo;

    #[Url(as: 'qa')]
    public $searchAsignadas = '';

    #[Url(as: 'qd')]
    public $searchDisponibles = '';

    public $perPageAsignadas = 10;

    public $perPageDisponibles = 10;

    public function mount($id)
    {
        $this->plantilla = Plantilla::findOrFail($id);
        $this->nombre = $this->plantilla->nombre;
        $this->descripcion = $this->plantilla->descripcion;
        $this->activo = (bool) $this->plantilla->activo;
    }

    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('plantillas', 'nombre')->ignore($this->plantilla->id)->whereNull('deleted_at')],
            'descripcion' => 'nullable|string',
            'activo' => 'required|boolean',
        ];
    }

    public function updated($property)
    {
        if (in_array($property, ['nombre', 'descripcion', 'activo'])) {
            $this->validateOnly($property);
        }

        if ($property === 'searchAsignadas' || $property === 'perPageAsignadas') {
            $this->resetPage('pageAsignadas');
        }
        if ($property === 'searchDisponibles' || $property === 'perPageDisponibles') {
            $this->resetPage('pageDisponibles');
        }
    }

    public function update()
    {
        // $this->authorize('plantilla.editar');

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

            $this->plantilla->update([
                'nombre' => trim($this->nombre),
                'descripcion' => trim($this->descripcion) ?: null,
                'activo' => $this->activo,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Actualizado!',
                'text' => 'La información básica se ha actualizado.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-plantilla')->error('[PLANTILLA] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->plantilla->id,
                'datos' => $this->all(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo actualizar la plantilla.',
            ]);
        }
    }

    public function agregarPregunta($preguntaId)
    {
        // $this->authorize('plantilla.asignar');

        try {
            DB::beginTransaction();

            // Calcular orden (el siguiente disponible)
            $ultimoOrden = $this->plantilla->preguntas()->max('plantilla_preguntas.orden') ?? 0;

            $this->plantilla->preguntas()->syncWithoutDetaching([
                $preguntaId => ['orden' => $ultimoOrden + 1],
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Agregada',
                'text' => 'La pregunta ha sido vinculada a la plantilla.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-plantilla')->error('[PLANTILLA] Error al agregar pregunta: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'plantilla_id' => $this->plantilla->id,
                'pregunta_id' => $preguntaId,
            ]);
        }
    }

    public function quitarPregunta($preguntaId)
    {
        // $this->authorize('plantilla.quitar');

        try {
            DB::beginTransaction();
            $this->plantilla->preguntas()->detach($preguntaId);
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Quitada',
                'text' => 'Pregunta desvinculada correctamente.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-plantilla')->error('[PLANTILLA] Error al quitar pregunta: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'plantilla_id' => $this->plantilla->id,
                'pregunta_id' => $preguntaId,
            ]);
        }
    }

    #[On('eliminarPlantillaOn')]
    public function eliminarPlantillaOn()
    {
        // $this->authorize('plantilla.eliminar');

        try {
            DB::beginTransaction();
            $this->plantilla->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminada',
                'text' => 'La plantilla ha sido eliminada.',
            ]);

            return redirect()->route('erp.plantilla.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-plantilla')->error('[PLANTILLA] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->plantilla->id,
            ]);
        }
    }

    public function render()
    {
        // Preguntas ya asignadas
        $preguntasAsignadas = $this->plantilla->preguntas()
            ->with('categoria')
            ->where(function ($q) {
                $q->where('texto', 'like', '%'.$this->searchAsignadas.'%')
                    ->orWhereHas('categoria', fn ($c) => $c->where('nombre', 'like', '%'.$this->searchAsignadas.'%'));
            })
            ->paginate($this->perPageAsignadas, ['*'], 'pageAsignadas');

        $idsAsignadas = $this->plantilla->preguntas()->allRelatedIds()->toArray();

        // Preguntas disponibles (no asignadas)
        $preguntasDisponibles = Pregunta::with('categoria')
            ->whereNotIn('id', $idsAsignadas)
            ->where('activo', true)
            ->where(function ($q) {
                $q->where('texto', 'like', '%'.$this->searchDisponibles.'%')
                    ->orWhereHas('categoria', fn ($c) => $c->where('nombre', 'like', '%'.$this->searchDisponibles.'%'));
            })
            ->orderBy('categoria_pregunta_id')
            ->orderBy('orden_sugerido')
            ->paginate($this->perPageDisponibles, ['*'], 'pageDisponibles');

        return view('livewire.erp.plantilla.plantilla-editar', [
            'preguntasAsignadas' => $preguntasAsignadas,
            'preguntasDisponibles' => $preguntasDisponibles,
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
