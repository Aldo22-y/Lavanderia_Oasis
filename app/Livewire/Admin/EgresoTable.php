<?php

namespace App\Livewire\Admin;

use App\Models\Egreso;
use Livewire\Component;
use Livewire\WithPagination;

class EgresoTable extends Component
{
    use WithPagination;

    public function render()
    {
        $egresos = Egreso::orderBy('fecha', 'desc')->paginate(10);

        // 👇 Esto es lo que asegura que $egresos esté disponible en el Blade
        return view('livewire.admin.egreso-table', [
            'egresos' => $egresos,
        ]);
    }
}
