<?php

namespace App\Livewire\Erp\Empresa;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\TipoDocumentoEmpresa;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Registrar Empresa')]
class EmpresaCrear extends Component
{
    public $cliente_id;
    public $tipo_documento_empresa_id;
    public string $razon_social = '';
    public string $nombre_comercial = '';
    public string $numero_documento = '';
    public string $direccion_fiscal = '';
    public bool $activo = true;

    protected $rules = [
        'cliente_id' => 'required|exists:clientes,id',
        'tipo_documento_empresa_id' => 'required|exists:tipo_documento_empresas,id',
        'razon_social' => 'required|string|max:255',
        'nombre_comercial' => 'nullable|string|max:255',
        'numero_documento' => 'required|string|max:20|unique:empresas,numero_documento',
        'direccion_fiscal' => 'nullable|string',
        'activo' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        Empresa::create([
            'cliente_id' => $this->cliente_id,
            'tipo_documento_empresa_id' => $this->tipo_documento_empresa_id,
            'razon_social' => $this->razon_social,
            'nombre_comercial' => $this->nombre_comercial,
            'numero_documento' => $this->numero_documento,
            'direccion_fiscal' => $this->direccion_fiscal,
            'activo' => $this->activo,
        ]);

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
