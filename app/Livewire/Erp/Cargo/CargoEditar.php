<?php

namespace App\Livewire\Erp\Cargo;

use App\Models\Cargo;
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
#[Title('Editar Cargo')]
class CargoEditar extends Component
{
    public Cargo $cargo;

    public $nombre;

    public $descripcion;

    public $color;

    public $icono;

    public $activo;

    public function mount($id)
    {
        $this->cargo = Cargo::findOrFail($id);
        $this->nombre = $this->cargo->nombre;
        $this->descripcion = $this->cargo->descripcion;
        $this->color = $this->cargo->color ?? '#64748b';
        $this->icono = $this->cargo->icono ?? 'fa-solid fa-briefcase';
        $this->activo = (bool) $this->cargo->activo;
    }

    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('cargos', 'nombre')->ignore($this->cargo->id)->whereNull('deleted_at')],
            'descripcion' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'icono' => 'nullable|string|max:100',
            'activo' => 'required|boolean',
        ];
    }

    public function validationAttributes()
    {
        return [
            'nombre' => 'nombre del cargo',
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
        // $this->authorize('cargo.editar');

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

            $this->cargo->update([
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
                'text' => 'El cargo se ha actualizado correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-cargo')->error('[CARGO] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->cargo->id,
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo actualizar el cargo.',
            ]);
        }
    }

    #[On('eliminarCargoOn')]
    public function eliminarCargoOn()
    {
        // $this->authorize('cargo.eliminar');

        try {
            DB::beginTransaction();
            $this->cargo->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminado',
                'text' => 'El cargo ha sido eliminado correctamente.',
            ]);

            return redirect()->route('erp.cargo.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-cargo')->error('[CARGO] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->cargo->id,
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
        return view('livewire.erp.cargo.cargo-editar');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
