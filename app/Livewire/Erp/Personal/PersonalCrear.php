<?php

namespace App\Livewire\Erp\Personal;

use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\Personal;
use App\Models\PersonalEmpresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Registrar Personal')]
class PersonalCrear extends Component
{
    public $nombre = '';

    public $dni = '';

    public $celular = '';

    public $activo = true;

    // Relación opcional inmediata con una empresa
    public $empresa_id = '';

    public $cargo_id = '';

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'dni' => 'nullable|string|max:20|unique:personals,dni',
            'celular' => 'nullable|string|max:50',
            'activo' => 'required|boolean',
            'empresa_id' => 'nullable|exists:empresas,id',
            'cargo_id' => 'nullable|exists:cargos,id',
        ];
    }

    public function validationAttributes()
    {
        return [
            'nombre' => 'nombre completo',
            'dni' => 'DNI/RUC',
            'celular' => 'teléfono/celular',
            'empresa_id' => 'empresa',
            'cargo_id' => 'cargo',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        // $this->authorize('personal.crear');

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

            $personal = Personal::create([
                'nombre' => trim($this->nombre),
                'dni' => trim($this->dni) ?: null,
                'celular' => trim($this->celular) ?: null,
                'activo' => $this->activo,
            ]);

            if ($this->empresa_id) {
                PersonalEmpresa::create([
                    'personal_id' => $personal->id,
                    'empresa_id' => $this->empresa_id,
                    'cargo_id' => $this->cargo_id ?: null,
                    'activo' => true,
                ]);
            }

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => 'El personal se ha registrado correctamente.',
            ]);

            return redirect()->route('erp.personal.vista.lista');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-personal')->error('[PERSONAL] Error al crear: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo registrar al personal. Intente nuevamente.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.personal.personal-crear', [
            'empresas' => Empresa::where('activo', true)->orderBy('razon_social')->get(),
            'cargos' => Cargo::where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-placeholder />
        HTML;
    }
}
