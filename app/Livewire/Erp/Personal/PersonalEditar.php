<?php

namespace App\Livewire\Erp\Personal;

use App\Models\Personal;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.erp')]
#[Title('Editar Personal')]
class PersonalEditar extends Component
{
    public Personal $personal;

    public string $nombre = '';
    public string $dni = '';
    public string $celular = '';
    public bool $activo = true;

    public function mount($id)
    {
        $this->personal = Personal::findOrFail($id);
        $this->nombre = $this->personal->nombre;
        $this->dni = $this->personal->dni ?? '';
        $this->celular = $this->personal->celular ?? '';
        $this->activo = $this->personal->activo;
    }

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'dni' => ['nullable', 'string', 'max:20', Rule::unique('personals', 'dni')->ignore($this->personal->id)],
            'celular' => ['nullable', 'string', 'max:20'],
            'activo' => ['boolean'],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->personal->update([
            'nombre' => $this->nombre,
            'dni' => $this->dni,
            'celular' => $this->celular,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Datos de personal actualizados.');

        return $this->redirect(route('erp.personal.vista.lista'), navigate: true);
    }

    public function delete()
    {
        $this->personal->delete();
        session()->flash('success', 'Registro de personal eliminado.');
        return $this->redirect(route('erp.personal.vista.lista'), navigate: true);
    }

    public function render()
    {
        return view('livewire.erp.personal.personal-editar');
    }
}
