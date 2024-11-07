<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile/username', [App\Http\Controllers\UserController::class, 'create'])->name('profile');

Route::get('/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('categorias');
Route::get('/categoria/platillos/{id}', [App\Http\Controllers\CategoriaController::class, 'create'])->name('platillos-categoria');
Route::post('/categoria/agregar', [App\Http\Controllers\CategoriaController::class, 'store'])->name('agregar-categoria');
Route::post('/categoria/buscar', [App\Http\Controllers\CategoriaController::class, 'show'])->name('buscar-categoria');
Route::post('/categoria/actualizar', [App\Http\Controllers\CategoriaController::class, 'update'])->name('actualizar-categoria');
Route::post('/categoria/borrar', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('borrar-categoria');

Route::get('/platillos', [App\Http\Controllers\PlatilloController::class, 'index'])->name('platillos');
Route::get('/platillo/ordenar/{id}', [App\Http\Controllers\PedidoHasPlatilloController::class, 'store'])->name('ordenar-platillo');
Route::post('/platillo/agregar', [App\Http\Controllers\PlatilloController::class, 'store'])->name('agregar-platillo');
Route::post('/platillo/buscar', [App\Http\Controllers\PlatilloController::class, 'show'])->name('buscar-platillo');
Route::post('/platillo/actualizar', [App\Http\Controllers\PlatilloController::class, 'update'])->name('actualizar-platillo');
Route::post('/platillo/borrar', [App\Http\Controllers\PlatilloController::class, 'destroy'])->name('borrar-platillo');
Route::post('/platillo/salsas', [App\Http\Controllers\PlatilloHasSalsaController::class, 'store'])->name('salsas-platillo');
Route::post('/platillo/preparaciones', [App\Http\Controllers\PlatilloHasPreparacionController::class, 'store'])->name('preparaciones-platillo');
Route::get('/platillo/preparar/{id}', [App\Http\Controllers\PlatilloController::class, 'create'])->name('preparar-platillo');
Route::post('/platillo/aderezos', [App\Http\Controllers\PlatilloHasAderezoController::class, 'store'])->name('aderezos-platillo');

Route::get('/salsas', [App\Http\Controllers\SalsaController::class, 'index'])->name('salsas');
Route::post('/salsa/agregar', [App\Http\Controllers\SalsaController::class, 'store'])->name('agregar-salsa');
Route::post('/salsa/buscar', [App\Http\Controllers\SalsaController::class, 'show'])->name('buscar-salsa');
Route::post('/salsa/actualizar', [App\Http\Controllers\SalsaController::class, 'update'])->name('actualizar-salsa');
Route::post('/salsa/borrar', [App\Http\Controllers\SalsaController::class, 'destroy'])->name('borrar-salsa');

Route::get('/preparaciones', [App\Http\Controllers\PreparacionController::class, 'index'])->name('preparaciones');
Route::post('/preparacion/agregar', [App\Http\Controllers\PreparacionController::class, 'store'])->name('agregar-preparacion');
Route::post('/preparacion/buscar', [App\Http\Controllers\PreparacionController::class, 'show'])->name('buscar-preparacion');
Route::post('/preparacion/actualizar', [App\Http\Controllers\PreparacionController::class, 'update'])->name('actualizar-preparacion');
Route::post('/preparacion/borrar', [App\Http\Controllers\PreparacionController::class, 'destroy'])->name('borrar-preparacion');

Route::get('/usuarios', [App\Http\Controllers\UserController::class, 'index'])->name('usuarios');
Route::post('/usuario/agregar', [App\Http\Controllers\UserController::class, 'store'])->name('agregar-usuario');
Route::post('/usuario/buscar', [App\Http\Controllers\UserController::class, 'show'])->name('buscar-usuario');
Route::post('/usuario/actualizar', [App\Http\Controllers\UserController::class, 'update'])->name('actualizar-usuario');
Route::post('/usuario/borrar', [App\Http\Controllers\UserController::class, 'destroy'])->name('borrar-usuario');
Route::post('/usuario/perfil', [App\Http\Controllers\UserController::class, 'edit'])->name('perfil-usuario');
Route::post('/usuario/token', [App\Http\Controllers\UserController::class, 'toke'])->name('token-usuario');

Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles');
Route::post('/role/agregar', [App\Http\Controllers\RoleController::class, 'store'])->name('agregar-role');
Route::post('/role/buscar', [App\Http\Controllers\RoleController::class, 'show'])->name('buscar-role');
Route::post('/role/actualizar', [App\Http\Controllers\RoleController::class, 'update'])->name('actualizar-role');
Route::post('/role/borrar', [App\Http\Controllers\RoleController::class, 'destroy'])->name('borrar-role');
Route::post('/role/permisos', [App\Http\Controllers\RoleController::class, 'create'])->name('permisos-role');

Route::get('/permisos', [App\Http\Controllers\PermisoController::class, 'index'])->name('permisos');
Route::post('/permiso/agregar', [App\Http\Controllers\PermisoController::class, 'store'])->name('agregar-permiso');
Route::post('/permiso/buscar', [App\Http\Controllers\PermisoController::class, 'show'])->name('buscar-permiso');
Route::post('/permiso/actualizar', [App\Http\Controllers\PermisoController::class, 'update'])->name('actualizar-permiso');
Route::post('/permiso/borrar', [App\Http\Controllers\PermisoController::class, 'destroy'])->name('borrar-permiso');

Route::get('/clientes', [App\Http\Controllers\ClienteController::class, 'index'])->name('clientes');
Route::post('/cliente/borrar', [App\Http\Controllers\ClienteController::class, 'destroy'])->name('borrar-cliente');
Route::post('/cliente/actualizar', [App\Http\Controllers\ClienteController::class, 'update'])->name('actualizar-cliente');

Route::post('/domicilio/agregar', [App\Http\Controllers\DomicilioController::class, 'store'])->name('agregar-domicilio');
Route::post('/domicilio/buscar', [App\Http\Controllers\DomicilioController::class, 'show'])->name('buscar-domicilio');
Route::post('/domicilio/actualizar', [App\Http\Controllers\DomicilioController::class, 'update'])->name('actualizar-domicilio');
Route::post('/domicilio/borrar', [App\Http\Controllers\DomicilioController::class, 'destroy'])->name('borrar-domicilio');

Route::post('/telefono/agregar', [App\Http\Controllers\TelefonoController::class, 'store'])->name('agregar-telefono');
Route::post('/telefono/buscar', [App\Http\Controllers\TelefonoController::class, 'show'])->name('buscar-telefono');
Route::post('/telefono/actualizar', [App\Http\Controllers\TelefonoController::class, 'update'])->name('actualizar-telefono');
Route::post('/telefono/borrar', [App\Http\Controllers\TelefonoController::class, 'destroy'])->name('borrar-telefono');

Route::get('/pedidos', [App\Http\Controllers\PedidoController::class, 'index'])->name('pedidos');
Route::get('/pedidos/cliente', [App\Http\Controllers\PedidoController::class, 'show'])->name('pedidos-cliente');
Route::get('/pedido/menu', [App\Http\Controllers\PedidoController::class, 'create'])->name('menu-pedido');
Route::get('/pedido/domicilios', [App\Http\Controllers\ClienteHasDomicilioController::class, 'index'])->name('domicilios-cliente');
Route::get('/pedido/ver/{idPedido}', [App\Http\Controllers\PedidoController::class, 'pedido'])->name('ver-pedido');
Route::post('/pedido/agregar', [App\Http\Controllers\PedidoController::class, 'store'])->name('agregar-pedido');
Route::post('/pedido/preparar', [App\Http\Controllers\PedidoHasPlatilloController::class, 'update'])->name('preparar-pedido');
Route::post('/pedido/platillo/preparar', [App\Http\Controllers\PedidoHasPlatilloController::class, 'create'])->name('preparar-platillo-pedido');
Route::post('/pedido/borrar', [App\Http\Controllers\PedidoHasPlatilloController::class, 'destroy'])->name('borrar-pedido');
Route::post('/pedido/sumar', [App\Http\Controllers\PedidoHasPlatilloController::class, 'sumar'])->name('sumar-pedido');
Route::post('/pedido/restar', [App\Http\Controllers\PedidoHasPlatilloController::class, 'restar'])->name('restar-pedido');
Route::post('/pedido/cancelar', [App\Http\Controllers\PedidoController::class, 'destroy'])->name('cancelar-pedido');
Route::post('/pedido/ordenar', [App\Http\Controllers\PedidoController::class, 'edit'])->name('ordenar-pedido');
Route::post('/pedido/pedir', [App\Http\Controllers\PedidoController::class, 'pedir'])->name('pedir-pedido');
Route::post('/pedido/entregar', [App\Http\Controllers\PedidoController::class, 'update'])->name('entregar-pedido');
Route::get('/pedido/confirmar/{id}', [App\Http\Controllers\PedidoController::class, 'impresion'])->name('confirmar-pedido');
Route::post('/pedido/notification/confirmado', [App\Http\Controllers\NotificationController::class, 'update'])->name('notificacion-leida');
Route::post('/pedido/cobrar', [App\Http\Controllers\PedidoController::class, 'cobrar'])->name('cobrar-pedido');
Route::post('/pedido/pagar', [App\Http\Controllers\PedidoController::class, 'pagar'])->name('pagar-pedido');
Route::post('/pedido/imprimir', [App\Http\Controllers\PedidoController::class, 'impresion'])->name('imprimir-pedido');
Route::post('/pedido/domicilio', [App\Http\Controllers\PedidoController::class, 'domicilio'])->name('domicilio-pedido');
Route::get('/pedido/ticket/{id}', [App\Http\Controllers\PedidoController::class, 'descargarTicket'])->name('ticket-pedido');
Route::get('/pedido/entrega/{id}', [App\Http\Controllers\PedidoController::class, 'descargarEntrega'])->name('entrega-pedido');
Route::get('/pedido/cancelado/{id}', [App\Http\Controllers\PedidoController::class, 'descargarCancelacion'])->name('pedido-cancelado');
Route::post('/pedido/editar', [App\Http\Controllers\PedidoController::class, 'editar'])->name('editar-pedido');
Route::post('/pedido/platillo/salsas', [App\Http\Controllers\PlatilloHasSalsaController::class, 'show'])->name('salsas-platillo-pedido');
Route::post('/pedido/platillo/preparaciones', [App\Http\Controllers\PlatilloHasPreparacionController::class, 'show'])->name('preparaciones-platillo-pedido');
Route::post('/pedido/platillo/aderezos', [App\Http\Controllers\PlatilloHasAderezoController::class, 'show'])->name('aderezos-platillo-pedido');
Route::post('/pedido/paquete/platillos', [App\Http\Controllers\PaqueteHasPlatilloController::class, 'show'])->name('platillos-paquete-pedido');
Route::post('/pedido/paquete/bebidas', [App\Http\Controllers\PaqueteHasBebidaController::class, 'show'])->name('platillo-paquete-bebidas');

Route::get('/cajas', [App\Http\Controllers\CajaController::class, 'index'])->name('cajas');
Route::post('/caja/agregar', [App\Http\Controllers\CajaController::class, 'store'])->name('agregar-caja');
Route::post('/caja/buscar', [App\Http\Controllers\CajaController::class, 'show'])->name('buscar-caja');
Route::post('/caja/actualizar', [App\Http\Controllers\CajaController::class, 'update'])->name('actualizar-caja');
Route::post('/caja/borrar', [App\Http\Controllers\CajaController::class, 'destroy'])->name('borrar-caja');
Route::post('/caja/abrir', [App\Http\Controllers\CajaController::class, 'create'])->name('abrir-caja');
Route::post('/caja/cerrar', [App\Http\Controllers\CajaController::class, 'edit'])->name('cerrar-caja');

Route::get('/movimientos/{idCaja}', [App\Http\Controllers\MovimientoController::class, 'index'])->name('movimientos-caja');
Route::post('/movimiento/agregar', [App\Http\Controllers\MovimientoController::class, 'store'])->name('agregar-movimiento');
Route::post('/movimiento/actualizar', [App\Http\Controllers\MovimientoController::class, 'update'])->name('actualizar-movimiento');
Route::post('/movimiento/buscar', [App\Http\Controllers\MovimientoController::class, 'show'])->name('buscar-movimiento');
Route::post('/movimiento/borrar', [App\Http\Controllers\MovimientoController::class, 'destroy'])->name('borrar-movimiento');

Route::get('/cortes/{idCaja}', [App\Http\Controllers\CorteController::class, 'index'])->name('cortes');
Route::post('/corte/calcular', [App\Http\Controllers\CorteController::class, 'create'])->name('calcular-corte');
Route::post('/corte/agregar', [App\Http\Controllers\CorteController::class, 'store'])->name('agregar-corte');
Route::post('/corte/borrar', [App\Http\Controllers\CorteController::class, 'destroy'])->name('borrar-corte');
Route::get('/corte/{idCorte}', [App\Http\Controllers\CorteController::class, 'show'])->name('buscar-corte');
Route::post('/corte/imprimir', [App\Http\Controllers\CorteController::class, 'edit'])->name('imprimir-corte');

Route::get('/envios', [App\Http\Controllers\EnvioController::class, 'index'])->name('envios');
Route::post('/envio/agregar', [App\Http\Controllers\EnvioController::class, 'store'])->name('agregar-envio');
Route::post('/envio/actualizar', [App\Http\Controllers\EnvioController::class, 'update'])->name('actualizar-envio');
Route::post('/envio/buscar', [App\Http\Controllers\EnvioController::class, 'show'])->name('buscar-envio');
Route::post('/envio/borrar', [App\Http\Controllers\EnvioController::class, 'destroy'])->name('borrar-envio');

Route::get('/paquetes', [App\Http\Controllers\PaqueteController::class, 'index'])->name('paquetes');
Route::post('/paquete/agregar', [App\Http\Controllers\PaqueteController::class, 'store'])->name('agregar-paquete');
Route::post('/paquete/buscar', [App\Http\Controllers\PaqueteController::class, 'show'])->name('buscar-paquete');
Route::post('/paquete/actualizar', [App\Http\Controllers\PaqueteController::class, 'update'])->name('actualizar-paquete');
Route::post('/paquete/borrar', [App\Http\Controllers\PaqueteController::class, 'destroy'])->name('borrar-paquete');
Route::post('/paquete/platillos', [App\Http\Controllers\PaqueteHasPlatilloController::class, 'store'])->name('agregar-platillos-paquete');
Route::post('/paquetes/bebidas', [App\Http\Controllers\PaqueteHasBebidaController::class, 'show'])->name('buscar-bebidas-paquete');
Route::post('/paquete/bebidas', [App\Http\Controllers\PaqueteHasBebidaController::class, 'store'])->name('agregar-bebidas-paquete');
Route::post('/pedido/paquete/ordenar', [App\Http\Controllers\PedidoHasPaqueteController::class, 'create'])->name('ordenar-paquete');
Route::post('/paquete/preparar', [App\Http\Controllers\PedidoHasPaqueteController::class, 'update'])->name('preparar-paquete');
Route::post('/paquete/eliminar', [App\Http\Controllers\PedidoHasPaqueteController::class, 'destroy'])->name('eliminar-paquete');
Route::post('/paquete/restar', [App\Http\Controllers\PedidoHasPaqueteController::class, 'restar'])->name('restar-paquete');
Route::post('/paquete/sumar', [App\Http\Controllers\PedidoHasPaqueteController::class, 'sumar'])->name('sumar-paquete');
Route::get('/paquete/platillo/preparar/{id}/{idPlatillo}', [App\Http\Controllers\PedidoHasPaqueteController::class, 'store'])->name('preparar-platillo-paquete');
Route::get('/paquete/bebida/preparar/{idPaquete}', [App\Http\Controllers\PedidoHasPaqueteController::class, 'show'])->name('preparar-bebida-paquete');

Route::get('/menu/descargar', [App\Http\Controllers\UserController::class, 'menu'])->name('descargar-menu');

Route::get('/aderezos', [App\Http\Controllers\AderezoController::class, 'index'])->name('aderezos');
Route::post('/aderezo/agregar', [App\Http\Controllers\AderezoController::class, 'store'])->name('agregar-aderezo');
Route::post('/aderezo/actualizar', [App\Http\Controllers\AderezoController::class, 'update'])->name('actualizar-aderezo');
Route::post('/aderezo/borrar', [App\Http\Controllers\AderezoController::class, 'destroy'])->name('borrar-aderezo');