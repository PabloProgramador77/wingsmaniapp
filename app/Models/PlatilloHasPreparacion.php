<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatilloHasPreparacion extends Model
{
    use HasFactory;

    protected $table = 'platillo_has_preparaciones';

    protected $fillable = [

        'idPlatillo',
        'idPreparacion',

    ];
}
