<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platillo extends Model
{
    use HasFactory;

    protected $table = 'platillos';

    protected $fillable = [

        'nombre',
        'precio',
        'descripcion',
        'idCategoria',

    ];

    public function categoria(){

        return $this->hasOne(Categoria::class, 'id', 'idCategoria');
        
    }

    public function salsas(){

        return $this->belongsToMany(Salsa::class, 'platillo_has_salsas', 'idPlatillo', 'idSalsa');
        
    }

}
