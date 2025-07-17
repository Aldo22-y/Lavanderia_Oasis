<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_apertura',
        'fecha_cierre',
        'total_ingresos',
        'total_egresos',
        'saldo_final',
    ];

    protected $casts = [
        'fecha_apertura' => 'datetime',
        'fecha_cierre' => 'datetime',
        'total_ingresos' => 'decimal:2',
        'total_egresos' => 'decimal:2',
        'saldo_final' => 'decimal:2',
    ];
}
