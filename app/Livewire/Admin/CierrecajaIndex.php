<?php

namespace App\Livewire\Admin;

use App\Models\Cierrecaja;
use App\Models\Caja;
use Livewire\Component;

class CierrecajaIndex extends Component
{
    public function render()
    {
        $cierres = Cierrecaja::all();
        $cajas = Caja::all(); // ✅ Asegúrate de definir esta línea

        return view('livewire.admin.cierrecaja-index', compact('cierres', 'cajas'));
    }
}
