<?php

namespace App\Livewire\Erp\TipoDocumentoEmpresa;

use App\Models\TipoDocumentoEmpresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Registrar Tipo de Documento')]
class TipoDocumentoEmpresaCrear extends Component
{
    public $nombre = '';

    public $abreviatura = '';

    public $color = '#3b82f6';

    public $icono = 'fa-solid fa-file-invoice';

    public $activo = true;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:tipo_documento_empresas,nombre',
            'abreviatura' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:20',
            'icono' => 'nullable|string|max:100',
            'activo' => 'required|boolean',
        ];
    }

    public function validationAttributes()
    {
        return [
            'nombre' => 'nombre del documento',
            'abreviatura' => 'abreviatura',
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
        // $this->authorize('tipo-documento-empresa.crear');

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

            TipoDocumentoEmpresa::create([
                'nombre' => trim($this->nombre),
                'abreviatura' => trim($this->abreviatura) ?: null,
                'color' => $this->color ?: null,
                'icono' => $this->icono ?: null,
                'activo' => $this->activo,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => 'El tipo de documento se ha registrado correctamente.',
            ]);

            return redirect()->route('erp.tipo-documento-empresa.vista.lista');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-tipo-documento-empresa')->error('[TIPO_DOC] Error al crear: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo registrar el tipo de documento. Intente nuevamente.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.tipo-documento-empresa.tipo-documento-empresa-crear');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
