<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteHasTelefono extends Model
{
    use HasFactory;

    protected $table = 'cliente_has_telefonos';

    protected $fillable = [

        'idCliente',
        'idTelefono'

    ];

}
