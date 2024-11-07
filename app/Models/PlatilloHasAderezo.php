<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatilloHasAderezo extends Model
{
    use HasFactory;

    protected $table = 'platillo_has_aderezos';

    protected $fillable = [

        'idPlatillo',
        'idAderezo',

    ];
}
