<?php

namespace App\Livewire\Erp\TipoDocumentoEmpresa;

use App\Models\TipoDocumentoEmpresa;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Tipo de Documento')]
class TipoDocumentoEmpresaEditar extends Component
{
    public TipoDocumentoEmpresa $tipo;

    public string $nombre = '';
    public string $abreviatura = '';
    public bool $activo = true;

    public function mount($id)
    {
        $this->tipo = TipoDocumentoEmpresa::findOrFail($id);
        $this->nombre = $this->tipo->nombre;
        $this->abreviatura = $this->tipo->abreviatura ?? '';
        $this->activo = $this->tipo->activo;
    }

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('tipo_documento_empresas', 'nombre')->ignore($this->tipo->id)],
            'abreviatura' => ['nullable', 'string', 'max:10'],
            'activo' => ['boolean'],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->tipo->update([
            'nombre' => $this->nombre,
            'abreviatura' => $this->abreviatura,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Tipo de documento actualizado correctamente.');

        return $this->redirect(route('erp.tipo-documento-empresa.vista.lista'), navigate: true);
    }

    public function delete()
    {
        $this->tipo->delete();
        session()->flash('success', 'Tipo de documento eliminado.');
        return $this->redirect(route('erp.tipo-documento-empresa.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.tipo-documento-empresa.tipo-documento-empresa-editar');
    }
}
