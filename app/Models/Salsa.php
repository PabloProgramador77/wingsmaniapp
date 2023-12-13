<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salsa extends Model
{
    use HasFactory;

    protected $table = 'salsas';

    protected $fillable = [

        'nombre'

    ];

    public function platillos(){

        return $this->belongsToMany(Platillo::class, 'platillo_has_salsas', 'idSalsa', 'idPlatillo');
        
    }
}
