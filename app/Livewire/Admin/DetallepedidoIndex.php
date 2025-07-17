<?php

namespace App\Livewire\Admin;

use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\TipoLavado;
use App\Models\TipoRopa;
use Livewire\Component;

class DetallePedidoIndex extends Component
{
    public function render()
    {
        $detallepedidos = DetallePedido::with(['pedido', 'tipoLavado', 'tipoRopa'])->get();
        $pedidos = Pedido::all();
        $tipolavados = TipoLavado::all();
        $tiporopas = TipoRopa::all();

        return view('livewire.admin.detallepedido-index', compact('detallepedidos', 'pedidos', 'tipolavados', 'tiporopas'));
    }
}
