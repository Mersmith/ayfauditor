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
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.erp.layout-erp')]
#[Title('Editar Participante')]
class ParticipanteAuditoriaEditar extends Component
{
    public ParticipanteAuditoria $participante;

    public $auditoria_id;

    public $user_id;

    public $cargo_id;

    public function mount($id)
    {
        $this->participante = ParticipanteAuditoria::findOrFail($id);
        $this->auditoria_id = $this->participante->auditoria_id;
        $this->user_id = $this->participante->user_id;
        $this->cargo_id = $this->participante->cargo_id;
    }

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

    public function update()
    {
        // $this->authorize('participante-auditoria.editar');

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

            $this->participante->update([
                'auditoria_id' => $this->auditoria_id,
                'user_id' => $this->user_id,
                'cargo_id' => $this->cargo_id,
            ]);

            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => '¡Actualizado!',
                'text' => 'La asignación se ha actualizado correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-participante-auditoria')->error('[PARTICIPANTE AUDITORIA] Error al actualizar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->participante->id,
                'datos' => $this->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error Crítico',
                'text' => 'No se pudo actualizar la asignación.',
            ]);
        }
    }

    #[On('eliminarParticipanteOn')]
    public function eliminarParticipanteOn()
    {
        // $this->authorize('participante-auditoria.eliminar');

        try {
            DB::beginTransaction();
            $this->participante->delete();
            DB::commit();

            $this->dispatch('alertaLivewire', [
                'type' => 'success',
                'title' => 'Eliminado',
                'text' => 'El participante ha sido retirado de la auditoría.',
            ]);

            return redirect()->route('erp.participante-auditoria.vista.lista');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('erp-participante-auditoria')->error('[PARTICIPANTE AUDITORIA] Error al eliminar: '.$e->getMessage(), [
                'usuario_id' => auth()->id(),
                'target_id' => $this->participante->id,
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('alertaLivewire', [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo retirar al participante.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.participante-auditoria.participante-auditoria-editar', [
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
