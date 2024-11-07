<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aderezo extends Model
{
    use HasFactory;

    protected $table = 'aderezos';

    protected $fillable = [

        'nombre',
        'descripcion',

    ];

    public function platillo(){

        return $this->hasOne( Platillo::class, 'idAderezo', 'idPlatillo');
        
    }
}
