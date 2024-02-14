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
        '/platillo/preparaciones',
        '/salsa/agregar',
        '/salsa/actualizar',
        '/salsa/buscar',
        '/salsa/borrar',
        '/preparacion/agregar',
        '/preparacion/actualizar',
        '/preparacion/buscar',
        '/preparacion/borrar',
        '/usuario/agregar',
        '/usuario/actualizar',
        '/usuario/buscar',
        '/usuario/borrar',
        '/usuario/perfil',
        '/role/agregar',
        '/role/actualizar',
        '/role/buscar',
        '/role/borrar',
        '/role/permisos',
        '/permiso/agregar',
        '/permiso/actualizar',
        '/permiso/buscar',
        '/permiso/borrar',
        '/cliente/borrar',
        '/cliente/actualizar',
        '/domicilio/agregar',
        '/domicilio/actualizar',
        '/domicilio/buscar',
        '/domicilio/borrar',
        '/telefono/agregar',
        '/telefono/actualizar',
        '/telefono/buscar',
        '/telefono/borrar',
        '/pedido/agregar',
        '/pedido/preparar',
        '/pedido/borrar',
        '/pedido/sumar',
        '/pedido/restar',
        '/pedido/cancelar',
        '/pedido/ordenar',
        '/pedido/entregar',
        '/pedido/confirmar',
        '/pedido/notification/confirmado',
        '/pedido/cobrar',
        '/pedido/pagar',
        '/caja/agregar',
        '/caja/actualizar',
        '/caja/buscar',
        '/caja/borrar',
        '/caja/abrir',
        '/caja/cerrar',

    ];
}
