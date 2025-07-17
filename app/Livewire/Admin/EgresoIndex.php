<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Egreso;

class EgresoIndex extends Component
{
    public $egresos; // Propiedad para almacenar los egresos

    public function mount()
    {
        $this->egresos = Egreso::all(); // Cargar todos los egresos al inicializar el componente
    }

    public function render()
    {
        return view('livewire.admin.egreso-index', [
            'egresos' => $this->egresos, // Pasar los egresos a la vista
        ]);
    }
}
