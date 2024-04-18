<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaqueteHasBebida extends Model
{
    use HasFactory;

    protected $table = 'paquete_has_bebidas';

    protected $fillable = [

        'idPaquete',
        'idBebida',

    ];
}
