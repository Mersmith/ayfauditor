<?php

namespace App\Livewire\Erp\ParticipanteAuditoria;

use App\Models\Auditoria;
use App\Models\Cargo;
use App\Models\ParticipanteAuditoria;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Asignar Participante')]
class ParticipanteAuditoriaCrear extends Component
{
    public $auditoria_id = '';

    public $user_id = '';

    public $cargo_id = '';

    protected function rules()
    {
        return [
            'auditoria_id' => 'required|exists:auditorias,id',
            'user_id' => 'required|exists:users,id',
            'cargo_id' => 'required|exists:cargos,id',
        ];
    }

    public function validationAttributes()
    {
        return [
            'auditoria_id' => 'auditoría',
            'user_id' => 'usuario',
            'cargo_id' => 'cargo',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        // $this->authorize('participante-auditoria.crear');

        try {
            $this->validate();

            // Verificar duplicidad
            $existe = ParticipanteAuditoria::where('auditoria_id', $this->auditoria_id)
                ->where('user_id', $this->user_id)
                ->exists();

            if ($existe) {
                $this->dispatch('alertaLivewire', [
                    'type' => 'warning',
                    'title' => 'Ya Asignado',
                    'text' => 'Este usuario ya participa en la auditoría seleccionada.',
                ]);

                return;
            }

        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', [
                'type' => 'warning',
                'title' => 'Datos Incompletos',
                'text' => 'Verifique los campos resaltados.',
            ]);
            throw $e;
        }

        try {
            DB::beginTransaction();

            ParticipanteAuditoria::create([
                'auditoria_id' => $this->auditoria_id,
                'user_id' => $this->user_id,
                'cargo_id' => $this->cargo_id,
                'invitado_por' => auth()->id(),
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Éxito!',
                'text' => 'El participante se ha asignado correctamente.',
            ]);

            return redirect()->route('erp.participante-auditoria.vista.lista');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-participante-auditoria')->error('[PARTICIPANTE AUDITORIA] Error al crear: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo realizar la asignación. Intente nuevamente.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.participante-auditoria.participante-auditoria-crear', [
            'auditorias' => Auditoria::orderBy('titulo')->get(),
            'usuarios' => User::orderBy('name')->get(),
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
