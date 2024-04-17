<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaqueteHasPlatillo extends Model
{
    use HasFactory;

    protected $table = 'paquete_has_platillos';

    protected $fillable = [

        'idPaquete',
        'idPlatillo',

    ];

}
