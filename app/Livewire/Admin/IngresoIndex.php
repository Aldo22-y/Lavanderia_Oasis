<?php

namespace App\Livewire\Admin;

use App\Models\Ingreso;
use App\Models\Pedido;
use Livewire\Component;

class IngresoIndex extends Component
{
    public function render()
    {
        $ingresos = Ingreso::with('pedido')->get(); // Carga pedidos relacionados
        $pedidos = Pedido::all();

        return view('livewire.admin.ingreso-index', compact('ingresos', 'pedidos'));
    }
}
