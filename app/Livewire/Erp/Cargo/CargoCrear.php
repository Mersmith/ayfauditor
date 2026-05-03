<?php

namespace App\Livewire\Erp\Cargo;

use App\Models\Cargo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Registrar Cargo')]
class CargoCrear extends Component
{
    public $nombre = '';

    public $descripcion = '';

    public $color = '#64748b';

    public $icono = 'fa-solid fa-briefcase';

    public $activo = true;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:cargos,nombre',
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

    public function store()
    {
        // $this->authorize('cargo.crear');

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

            Cargo::create([
                'nombre' => trim($this->nombre),
                'descripcion' => trim($this->descripcion) ?: null,
                'color' => $this->color ?: null,
                'icono' => $this->icono ?: null,
                'activo' => $this->activo,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => 'El cargo se ha registrado correctamente.',
            ]);

            return redirect()->route('erp.cargo.vista.lista');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-cargo')->error('[CARGO] Error al crear: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo registrar el cargo. Intente nuevamente.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.cargo.cargo-crear');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
