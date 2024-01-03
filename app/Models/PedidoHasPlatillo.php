<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoHasPlatillo extends Model
{
    use HasFactory;

    protected $table = 'pedido_has_platillos';

    protected $fillable = [
        
        'idPedido', 'idPlatillo', 'cantidad', 'preparacion'

    ];
    
}
