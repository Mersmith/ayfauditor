<?php

namespace App\Livewire\Erp\Pregunta;

use App\Models\CategoriaPregunta;
use App\Models\Pregunta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Registrar Pregunta')]
class PreguntaCrear extends Component
{
    public $texto = '';

    public $categoria_pregunta_id = '';

    public $orden_sugerido = 0;

    public $descripcion_ayuda = '';

    public $activo = true;

    protected function rules()
    {
        return [
            'texto' => 'required|string|max:1000|unique:preguntas,texto',
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

    public function store()
    {
        // $this->authorize('pregunta.crear');

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

            Pregunta::create([
                'texto' => trim($this->texto),
                'categoria_pregunta_id' => $this->categoria_pregunta_id,
                'orden_sugerido' => $this->orden_sugerido ?: 0,
                'descripcion_ayuda' => trim($this->descripcion_ayuda) ?: null,
                'activo' => $this->activo,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => 'La pregunta se ha registrado correctamente.',
            ]);

            return redirect()->route('erp.pregunta.vista.lista');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-pregunta')->error('[PREGUNTA] Error al crear: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo registrar la pregunta. Intente nuevamente.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.pregunta.pregunta-crear', [
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
