<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteHasDomicilio extends Model
{
    use HasFactory;

    protected $table = 'cliente_has_domicilios';

    protected $fillable = [

        'idCliente',
        'idDomicilio'

    ];
}
