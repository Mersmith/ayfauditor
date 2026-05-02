<?php

namespace App\Livewire\Erp\TipoDocumentoEmpresa;

use App\Models\TipoDocumentoEmpresa;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Crear Tipo de Documento')]
class TipoDocumentoEmpresaCrear extends Component
{
    public string $nombre = '';
    public string $abreviatura = '';
    public bool $activo = true;

    protected $rules = [
        'nombre' => 'required|string|max:255|unique:tipo_documento_empresas,nombre',
        'abreviatura' => 'nullable|string|max:10',
        'activo' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        TipoDocumentoEmpresa::create([
            'nombre' => $this->nombre,
            'abreviatura' => $this->abreviatura,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Tipo de documento creado correctamente.');

        return $this->redirect(route('erp.tipo-documento-empresa.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.tipo-documento-empresa.tipo-documento-empresa-crear');
    }
}
