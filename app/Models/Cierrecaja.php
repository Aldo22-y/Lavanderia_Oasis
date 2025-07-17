<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cierrecaja extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_caja',
        'fecha',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    // Relación con el modelo Caja
    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }
}
