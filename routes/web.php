<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
Route::post('/pedido/borrar', [App\Http\Controllers\PedidoHasPlatilloController::class, 'destroy'])->name('borrar-pedido');
Route::post('/pedido/sumar', [App\Http\Controllers\PedidoHasPlatilloController::class, 'sumar'])->name('sumar-pedido');
Route::post('/pedido/restar', [App\Http\Controllers\PedidoHasPlatilloController::class, 'restar'])->name('restar-pedido');
Route::post('/pedido/cancelar', [App\Http\Controllers\PedidoController::class, 'destroy'])->name('cancelar-pedido');
Route::post('/pedido/ordenar', [App\Http\Controllers\PedidoController::class, 'edit'])->name('ordenar-pedido');
Route::post('/pedido/entregar', [App\Http\Controllers\PedidoController::class, 'update'])->name('entregar-pedido');
Route::post('/pedido/confirmar', [App\Http\Controllers\PedidoController::class, 'confirmar'])->name('confirmar-pedido');
Route::post('/pedido/notification/confirmado', [App\Http\Controllers\NotificationController::class, 'update'])->name('notificacion-leida');
Route::post('/pedido/cobrar', [App\Http\Controllers\PedidoController::class, 'cobrar'])->name('cobrar-pedido');