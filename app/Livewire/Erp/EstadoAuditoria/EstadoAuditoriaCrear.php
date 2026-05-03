<?php

namespace App\Livewire\Erp\EstadoAuditoria;

use App\Models\EstadoAuditoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Registrar Estado de Auditoría')]
class EstadoAuditoriaCrear extends Component
{
    public $nombre = '';

    public $color = '#3490dc';

    public $icono = 'fa-solid fa-circle-check';

    public $descripcion = '';

    public $activo = true;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:estado_auditorias,nombre',
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

    public function store()
    {
        // $this->authorize('estado-auditoria.crear');

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

            EstadoAuditoria::create([
                'nombre' => trim($this->nombre),
                'color' => $this->color ?: '#3490dc',
                'icono' => $this->icono ?: 'fa-solid fa-circle-check',
                'descripcion' => trim($this->descripcion) ?: null,
                'activo' => $this->activo,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => 'El estado se ha registrado correctamente.',
            ]);

            return redirect()->route('erp.estado-auditoria.vista.lista');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-estado-auditoria')->error('[ESTADO AUDITORIA] Error al crear: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo registrar el estado. Intente nuevamente.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.estado-auditoria.estado-auditoria-crear');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
