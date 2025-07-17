<?php

namespace App\Livewire\Admin;

use App\Models\Cliente;
use Livewire\Component;

class ClienteTable extends Component
{
    public function render()
    {
        $clientes = Cliente::orderBy('created_at', 'desc')
        ->paginate(10);

        return view('livewire.admin.cliente-table', compact('clientes'));

    }
}
