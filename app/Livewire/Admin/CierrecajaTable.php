<?php

namespace App\Livewire\Admin;

use App\Models\Cierrecaja;
use Livewire\Component;
use Livewire\WithPagination;

class CierrecajaTable extends Component
{
    use WithPagination;

    public function render()
    {
        $cierres = Cierrecaja::orderBy('fecha', 'desc')->paginate(10);

        return view('livewire.admin.cierrecaja-table', compact('cierres'));
    }
}
