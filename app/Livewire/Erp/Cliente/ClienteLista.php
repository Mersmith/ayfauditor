<?php

namespace App\Livewire\Erp\Cliente;

use App\Models\Cliente;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp')]
#[Title('Lista de Clientes')]
class ClienteLista extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.erp.cliente.cliente-lista', [
            'clientes' => Cliente::with('user')->paginate(10),
        ]);
    }
}
