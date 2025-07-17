<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipolavado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];
}
