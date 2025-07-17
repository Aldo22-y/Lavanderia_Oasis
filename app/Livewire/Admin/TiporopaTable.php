<?php

namespace App\Livewire\Admin;

use App\Models\Tiporopa;
use Livewire\Component;
use Livewire\WithPagination;

class TiporopaTable extends Component
{
    use WithPagination;

    public function render()
    {
        $tiporopas = Tiporopa::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.tiporopa-table', compact('tiporopas'));
    }
}
