<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pedido',
        'id_tipolavado',
        'id_tiporopa',
        'cantidad',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    // Relación con el modelo Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    // Relación con el modelo TipoLavado
    public function tipoLavado()
    {
        return $this->belongsTo(TipoLavado::class, 'id_tipolavado');
    }

    // Relación con el modelo TipoRopa
    public function tipoRopa()
    {
        return $this->belongsTo(TipoRopa::class, 'id_tiporopa');
    }
}
