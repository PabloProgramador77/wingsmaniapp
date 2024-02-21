<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorteHasPedidos extends Model
{
    use HasFactory;

    protected $table = 'corte_has_pedidos';

    protected $fillable = [

        'idCorte', 'idPedido'

    ];
}
