<?php

namespace App\Livewire\Admin;

use App\Models\Tipolavado;
use Livewire\Component;
use Livewire\WithPagination;

class TipolavadoTable extends Component
{
    use WithPagination;

    public function render()
    {
        $tipos_lavado = Tipolavado::orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.tipolavado-table', compact('tipos_lavado'));
    }
}
