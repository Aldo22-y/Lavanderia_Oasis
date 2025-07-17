<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cliente',
        'fecha_ingreso',
        'fecha_entrega',
        'total',
        'status',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'fecha_entrega' => 'date',
        'total' => 'decimal:2',
        'status' => 'boolean',
    ];

    // Relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
