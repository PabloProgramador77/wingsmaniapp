<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    use HasFactory;

    protected $table = 'paquetes';

    protected $fillable = [

        'nombre',
        'precio',
        'descripcion',
        'cantidadBebidas',
        'cantidadSalsas',
        'idCategoria',
        'diaActivacion',

    ];

    public function platillos(){

        return $this->belongsToMany( Platillo::class, 'paquete_has_platillos', 'idPaquete', 'idPlatillo' );
        
    }

    public function categoria(){

        return $this->hasOne( Categoria::class, 'id', 'idCategoria' );
        
    }

    public function bebidas(){

        return $this->belongsToMany( Platillo::class, 'paquete_has_bebidas', 'idPaquete', 'idBebida' );
        
    }
}
