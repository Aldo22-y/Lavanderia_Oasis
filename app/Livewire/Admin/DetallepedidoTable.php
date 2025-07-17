<?php

namespace App\Livewire\Admin;

use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\TipoLavado;
use App\Models\TipoRopa;
use Livewire\Component;
use Livewire\WithPagination;

class DetallePedidoTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; // o 'tailwind' si estás usando Tailwind

    public function render()
    {
        $detallepedidos = DetallePedido::with(['pedido', 'tipoLavado', 'tipoRopa'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $pedidos = Pedido::all();
        $tipolavados = TipoLavado::all();
        $tiporopas = TipoRopa::all();

        return view('livewire.admin.detallepedido-table', compact('detallepedidos', 'pedidos', 'tipolavados', 'tiporopas'));
    }
}
