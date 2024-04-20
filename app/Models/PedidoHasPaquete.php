<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoHasPaquete extends Model
{
    use HasFactory;

    protected $table = 'pedido_has_paquetes';

    protected $fillable = [

        'idPedido',
        'idPaquete',
        'cantidad',
        'preparacion',

    ];

    public function pedido(){

        return $this->hasOne( Pedido::class, 'id', 'idPedido' );

    }

    public function paquete(){

        return $this->hasOne( Paquete::class, 'id', 'idPaquete' );

    }
}
