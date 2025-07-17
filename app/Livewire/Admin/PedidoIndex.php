<?php

namespace App\Livewire\Admin;

use App\Models\Cliente;
use App\Models\Pedido;
use Livewire\Component;

class PedidoIndex extends Component
{
    public function render()
    {
        $pedidos = Pedido::all();
        $clientes = Cliente::all();
        return view('livewire.admin.pedido-index', compact('clientes', 'pedidos'));
    }
}
