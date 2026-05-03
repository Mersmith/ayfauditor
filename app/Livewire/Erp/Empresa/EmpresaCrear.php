<?php

namespace App\Livewire\Erp\Empresa;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\TipoDocumentoEmpresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Crear Empresa')]
class EmpresaCrear extends Component
{
    use WithFileUploads;

    public $cliente_id = '';

    public $tipo_documento_empresa_id = '';

    public $razon_social = '';

    public $nombre_comercial = '';

    public $numero_documento = '';

    public $direccion_fiscal = '';

    public $telefono = '';

    public $correo = '';

    public $website = '';

    public $activo = true;

    // Archivos
    public $logo;

    public $escudo;

    protected function rules()
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_documento_empresa_id' => 'required|exists:tipo_documento_empresas,id',
            'razon_social' => 'required|string|max:255',
            'nombre_comercial' => 'nullable|string|max:255',
            'numero_documento' => 'required|string|max:20|unique:empresas,numero_documento',
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

    public function store()
    {
        // $this->authorize('empresa.crear');

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

            $empresa = Empresa::create([
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
                $empresa->addMedia($this->logo)->toMediaCollection('logo');
            }

            if ($this->escudo) {
                $empresa->addMedia($this->escudo)->toMediaCollection('escudo');
            }

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => 'La empresa se ha registrado correctamente.',
            ]);

            return redirect()->route('erp.empresa.vista.lista');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-empresa')->error('[EMPRESA] Error al crear: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo registrar la empresa. Intente nuevamente.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.empresa.empresa-crear', [
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
