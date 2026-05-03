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

    public string $color = '';

    public string $icono = '';

    public bool $activo = true;

    protected $rules = [
        'nombre' => 'required|string|max:255|unique:tipo_documento_empresas,nombre',
        'abreviatura' => 'nullable|string|max:10',
        'color' => 'nullable|string|max:50',
        'icono' => 'nullable|string|max:100',
        'activo' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        TipoDocumentoEmpresa::create([
            'nombre' => $this->nombre,
            'abreviatura' => $this->abreviatura,
            'color' => $this->color,
            'icono' => $this->icono,
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
