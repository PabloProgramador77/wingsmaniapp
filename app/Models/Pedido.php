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
        'idCliente',
        'idDomicilio',
        'idEnvio',

    ];

    public function cliente(){

        return $this->hasOne( User::class, 'id', 'idCliente' );
        
    }

    public function platillos(){

        return $this->belongsToMany( Platillo::class, 'pedido_has_platillos', 'idPedido', 'idPlatillo' );
        
    }

    public function envio(){

        return $this->hasOne( Envio::class, 'id', 'idEnvio' );
        
    }

    public function domicilio(){

        return $this->hasOne( Domicilio::class, 'id', 'idDomicilio' );
        
    }
}
