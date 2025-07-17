<?php

namespace App\Livewire\Admin;

use App\Models\Ingreso;
use Livewire\Component;
use Livewire\WithPagination;

class IngresoTable extends Component
{
    use WithPagination;

    public function render()
    {
        $ingresos = Ingreso::with('pedido.cliente') // Incluye relaciones necesarias
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('livewire.admin.ingreso-table', compact('ingresos'));
    }
}
