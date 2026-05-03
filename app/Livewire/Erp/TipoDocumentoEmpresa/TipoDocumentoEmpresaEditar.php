<?php

namespace App\Livewire\Erp\TipoDocumentoEmpresa;

use App\Models\TipoDocumentoEmpresa;
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
#[Title('Editar Tipo de Documento')]
class TipoDocumentoEmpresaEditar extends Component
{
    public TipoDocumentoEmpresa $tipoDoc;

    public $nombre;

    public $abreviatura;

    public $color;

    public $icono;

    public $activo;

    public function mount($id)
    {
        $this->tipoDoc = TipoDocumentoEmpresa::findOrFail($id);
        $this->nombre = $this->tipoDoc->nombre;
        $this->abreviatura = $this->tipoDoc->abreviatura;
        $this->color = $this->tipoDoc->color ?? '#3b82f6';
        $this->icono = $this->tipoDoc->icono ?? 'fa-solid fa-file-invoice';
        $this->activo = (bool) $this->tipoDoc->activo;
    }

    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('tipo_documento_empresas', 'nombre')->ignore($this->tipoDoc->id)->whereNull('deleted_at')],
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

    public function update()
    {
        // $this->authorize('tipo-documento-empresa.editar');

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

            $this->tipoDoc->update([
                'nombre' => trim($this->nombre),
                'abreviatura' => trim($this->abreviatura) ?: null,
                'color' => $this->color ?: null,
                'icono' => $this->icono ?: null,
                'activo' => $this->activo,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Actualizado!',
                'text' => 'El tipo de documento se ha actualizado correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-tipo-documento-empresa')->error('[TIPO_DOC] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->tipoDoc->id,
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo actualizar el tipo de documento.',
            ]);
        }
    }

    #[On('eliminarTipoDocOn')]
    public function eliminarTipoDocOn()
    {
        // $this->authorize('tipo-documento-empresa.eliminar');

        try {
            DB::beginTransaction();
            $this->tipoDoc->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminado',
                'text' => 'El tipo de documento ha sido eliminado correctamente.',
            ]);

            return redirect()->route('erp.tipo-documento-empresa.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-tipo-documento-empresa')->error('[TIPO_DOC] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->tipoDoc->id,
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
        return view('livewire.erp.tipo-documento-empresa.tipo-documento-empresa-editar');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
