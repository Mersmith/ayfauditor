<?php

namespace App\Livewire\Erp\Empresa;

use App\Models\Cliente;
use App\Models\Empresa;
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
use Livewire\WithFileUploads;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Editar Empresa')]
class EmpresaEditar extends Component
{
    use WithFileUploads;

    public Empresa $empresa;

    public $cliente_id;

    public $tipo_documento_empresa_id;

    public $razon_social;

    public $nombre_comercial;

    public $numero_documento;

    public $direccion_fiscal;

    public $telefono;

    public $correo;

    public $website;

    public $activo;

    // Archivos
    public $logo;

    public $escudo;

    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->cliente_id = $this->empresa->cliente_id;
        $this->tipo_documento_empresa_id = $this->empresa->tipo_documento_empresa_id;
        $this->razon_social = $this->empresa->razon_social;
        $this->nombre_comercial = $this->empresa->nombre_comercial;
        $this->numero_documento = $this->empresa->numero_documento;
        $this->direccion_fiscal = $this->empresa->direccion_fiscal;
        $this->telefono = $this->empresa->telefono;
        $this->correo = $this->empresa->correo;
        $this->website = $this->empresa->website;
        $this->activo = (bool) $this->empresa->activo;
    }

    protected function rules()
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_documento_empresa_id' => 'required|exists:tipo_documento_empresas,id',
            'razon_social' => 'required|string|max:255',
            'nombre_comercial' => 'nullable|string|max:255',
            'numero_documento' => ['required', 'string', 'max:20', Rule::unique('empresas', 'numero_documento')->ignore($this->empresa->id)->whereNull('deleted_at')],
            'direccion_fiscal' => 'nullable|string',
            'telefono' => 'nullable|string|max:50',
            'correo' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
            'escudo' => 'nullable|image|max:2048',
            'activo' => 'required|boolean',
        ];
    }

    public function validationAttributes()
    {
        return [
            'cliente_id' => 'cliente principal',
            'tipo_documento_empresa_id' => 'tipo de documento',
            'razon_social' => 'razón social',
            'nombre_comercial' => 'nombre comercial',
            'numero_documento' => 'número de documento',
            'direccion_fiscal' => 'dirección fiscal',
            'telefono' => 'teléfono/celular',
            'correo' => 'correo electrónico',
            'website' => 'sitio web',
            'logo' => 'logotipo',
            'escudo' => 'escudo/sello',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        // $this->authorize('empresa.editar');

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

            $this->empresa->update([
                'cliente_id' => $this->cliente_id,
                'tipo_documento_empresa_id' => $this->tipo_documento_empresa_id,
                'razon_social' => trim($this->razon_social),
                'nombre_comercial' => trim($this->nombre_comercial),
                'numero_documento' => trim($this->numero_documento),
                'direccion_fiscal' => trim($this->direccion_fiscal),
                'telefono' => trim($this->telefono),
                'correo' => strtolower(trim($this->correo)),
                'website' => strtolower(trim($this->website)),
                'activo' => $this->activo,
            ]);

            if ($this->logo) {
                $this->empresa->clearMediaCollection('logo');
                $this->empresa->addMedia($this->logo)->toMediaCollection('logo');
            }

            if ($this->escudo) {
                $this->empresa->clearMediaCollection('escudo');
                $this->empresa->addMedia($this->escudo)->toMediaCollection('escudo');
            }

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => 'La empresa se ha actualizado correctamente.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-empresa')->error('[EMPRESA] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->empresa->id,
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo actualizar la empresa.',
            ]);
        }
    }

    #[On('eliminarEmpresaOn')]
    public function eliminarEmpresaOn()
    {
        // $this->authorize('empresa.eliminar');

        try {
            DB::beginTransaction();
            $this->empresa->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminado',
                'text' => 'La empresa ha sido eliminada correctamente.',
            ]);

            return redirect()->route('erp.empresa.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-empresa')->error('[EMPRESA] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->empresa->id,
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo eliminar la empresa.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.empresa.empresa-editar', [
            'clientes' => Cliente::where('activo', true)->orderBy('nombre')->get(),
            'tiposDocumento' => TipoDocumentoEmpresa::where('activo', true)->get(),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
