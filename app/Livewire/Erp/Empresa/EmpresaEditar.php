<?php

namespace App\Livewire\Erp\Empresa;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\TipoDocumentoEmpresa;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Empresa')]
class EmpresaEditar extends Component
{
    public Empresa $empresa;

    public $cliente_id;
    public $tipo_documento_empresa_id;
    public string $razon_social = '';
    public string $nombre_comercial = '';
    public string $numero_documento = '';
    public string $direccion_fiscal = '';
    public bool $activo = true;

    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->cliente_id = $this->empresa->cliente_id;
        $this->tipo_documento_empresa_id = $this->empresa->tipo_documento_empresa_id;
        $this->razon_social = $this->empresa->razon_social;
        $this->nombre_comercial = $this->empresa->nombre_comercial ?? '';
        $this->numero_documento = $this->empresa->numero_documento;
        $this->direccion_fiscal = $this->empresa->direccion_fiscal ?? '';
        $this->activo = $this->empresa->activo;
    }

    protected function rules(): array
    {
        return [
            'cliente_id' => ['required', 'exists:clientes,id'],
            'tipo_documento_empresa_id' => ['required', 'exists:tipo_documento_empresas,id'],
            'razon_social' => ['required', 'string', 'max:255'],
            'nombre_comercial' => ['nullable', 'string', 'max:255'],
            'numero_documento' => ['required', 'string', 'max:20', Rule::unique('empresas', 'numero_documento')->ignore($this->empresa->id)],
            'direccion_fiscal' => ['nullable', 'string'],
            'activo' => ['boolean'],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->empresa->update([
            'cliente_id' => $this->cliente_id,
            'tipo_documento_empresa_id' => $this->tipo_documento_empresa_id,
            'razon_social' => $this->razon_social,
            'nombre_comercial' => $this->nombre_comercial,
            'numero_documento' => $this->numero_documento,
            'direccion_fiscal' => $this->direccion_fiscal,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Empresa actualizada correctamente.');

        return $this->redirect(route('erp.empresa.vista.lista'), navigate: true);
    }

    public function delete()
    {
        $this->empresa->delete();
        session()->flash('success', 'Empresa eliminada.');
        return $this->redirect(route('erp.empresa.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.empresa.empresa-editar', [
            'clientes' => Cliente::where('activo', true)->get(),
            'tipos' => TipoDocumentoEmpresa::where('activo', true)->get(),
        ]);
    }
}
