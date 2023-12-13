<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        
        '/categoria/agregar',
        '/categoria/actualizar',
        '/categoria/buscar',
        '/categoria/borrar',
        '/platillo/agregar',
        '/platillo/actualizar',
        '/platillo/buscar',
        '/platillo/borrar',
        '/platillo/salsas',
        '/salsa/agregar',
        '/salsa/actualizar',
        '/salsa/buscar',
        '/salsa/borrar',

    ];
}
