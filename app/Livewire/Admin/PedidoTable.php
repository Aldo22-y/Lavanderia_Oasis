<?php

namespace App\Livewire\Admin;

use App\Models\Pedido;
use Livewire\Component;
use Livewire\WithPagination;

class PedidoTable extends Component
{
    use WithPagination;

    public function render()
    {
        $pedidos = Pedido::with('cliente')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.pedido-table', compact('pedidos'));
    }
}
