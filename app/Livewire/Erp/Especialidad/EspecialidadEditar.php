<?php

namespace App\Livewire\Erp\Especialidad;

use App\Models\Especialidad;
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
#[Title('Editar Especialidad')]
class EspecialidadEditar extends Component
{
    public Especialidad $especialidad;

    public $nombre;

    public $descripcion;

    public $color;

    public $icono;

    public $activo;

    public function mount($id)
    {
        $this->especialidad = Especialidad::findOrFail($id);
        $this->nombre = $this->especialidad->nombre;
        $this->descripcion = $this->especialidad->descripcion;
        $this->color = $this->especialidad->color ?? '#3b82f6';
        $this->icono = $this->especialidad->icono ?? 'fa-solid fa-graduation-cap';
        $this->activo = (bool) $this->especialidad->activo;
    }

    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('especialidads', 'nombre')->ignore($this->especialidad->id)->whereNull('deleted_at')],
            'descripcion' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'icono' => 'nullable|string|max:100',
            'activo' => 'required|boolean',
        ];
    }

    public function validationAttributes()
    {
        return [
            'nombre' => 'nombre de la especialidad',
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
        // $this->authorize('especialidad.editar');

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

            $this->especialidad->update([
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
                'text' => 'La especialidad se ha actualizado correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-especialidad')->error('[ESPECIALIDAD] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->especialidad->id,
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo actualizar la especialidad.',
            ]);
        }
    }

    #[On('eliminarEspecialidadOn')]
    public function eliminarEspecialidadOn()
    {
        // $this->authorize('especialidad.eliminar');

        try {
            DB::beginTransaction();
            $this->especialidad->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminada',
                'text' => 'La especialidad ha sido eliminada correctamente.',
            ]);

            return redirect()->route('erp.especialidad.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-especialidad')->error('[ESPECIALIDAD] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->especialidad->id,
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
        return view('livewire.erp.especialidad.especialidad-editar');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
