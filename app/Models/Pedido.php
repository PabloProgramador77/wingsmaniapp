<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [

        'total',
        'estatus',
        'tipo',
        'idCliente'

    ];

    public function cliente(){

        return $this->hasOne( User::class, 'id', 'idCliente' );
        
    }

    public function platillos(){

        if( session()->get('idPedido') ){

            return $this->belongsToMany(Platillo::class, 'pedido_has_platillos', 'idPedido', 'idPlatillo');

        }
        
    }
}
