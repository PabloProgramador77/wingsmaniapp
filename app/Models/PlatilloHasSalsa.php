<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatilloHasSalsa extends Model
{
    use HasFactory;

    protected $table = 'platillo_has_salsas';

    protected $fillable = [

        'idPlatillo',
        'idSalsa'

    ];

}
