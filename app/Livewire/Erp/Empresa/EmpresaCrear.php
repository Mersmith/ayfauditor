<?php

namespace App\Livewire\Erp\Empresa;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\TipoDocumentoEmpresa;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.erp')]
#[Title('Registrar Empresa')]
class EmpresaCrear extends Component
{
    use WithFileUploads;

    public $cliente_id;

    public $tipo_documento_empresa_id;

    public string $razon_social = '';

    public string $nombre_comercial = '';

    public string $numero_documento = '';

    public string $direccion_fiscal = '';

    public string $telefono = '';

    public string $correo = '';

    public string $website = '';

    public $logo;

    public $escudo;

    public bool $activo = true;

    protected $rules = [
        'cliente_id' => 'required|exists:clientes,id',
        'tipo_documento_empresa_id' => 'required|exists:tipo_documento_empresas,id',
        'razon_social' => 'required|string|max:255',
        'nombre_comercial' => 'nullable|string|max:255',
        'numero_documento' => 'required|string|max:20|unique:empresas,numero_documento',
        'direccion_fiscal' => 'nullable|string',
        'telefono' => 'nullable|string|max:50',
        'correo' => 'nullable|email|max:255',
        'website' => 'nullable|string|max:255',
        'logo' => 'nullable|image|max:2048',
        'escudo' => 'nullable|image|max:2048',
        'activo' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $empresa = Empresa::create([
            'cliente_id' => $this->cliente_id,
            'tipo_documento_empresa_id' => $this->tipo_documento_empresa_id,
            'razon_social' => $this->razon_social,
            'nombre_comercial' => $this->nombre_comercial,
            'numero_documento' => $this->numero_documento,
            'direccion_fiscal' => $this->direccion_fiscal,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'website' => $this->website,
            'activo' => $this->activo,
        ]);

        if ($this->logo) {
            $empresa->addMedia($this->logo)->toMediaCollection('logo');
        }

        if ($this->escudo) {
            $empresa->addMedia($this->escudo)->toMediaCollection('escudo');
        }

        session()->flash('success', 'Empresa registrada correctamente.');

        return $this->redirect(route('erp.empresa.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.empresa.empresa-crear', [
            'clientes' => Cliente::where('activo', true)->get(),
            'tipos' => TipoDocumentoEmpresa::where('activo', true)->get(),
        ]);
    }
}
