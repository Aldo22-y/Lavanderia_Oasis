<?php

namespace App\Livewire\Admin;

use App\Models\Caja;
use Livewire\Component;
use Livewire\WithPagination;

class CajaTable extends Component
{
    use WithPagination;

    public function render()
    {
        $cajas = Caja::orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.caja-table', compact('cajas'));
    }
}
