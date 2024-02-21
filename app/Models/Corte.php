<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corte extends Model
{
    use HasFactory;

    protected $table = 'cortes';

    protected $fillable = [

        'nombre', 'total', 'idCaja'

    ];

    public function caja(){

        return $this->hasOne( Caja::class, 'id', 'idCaja' );
        
    }
}
