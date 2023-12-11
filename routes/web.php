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
Route::get('/profile/username', [App\Http\Controllers\HomeController::class, 'index'])->name('profile');

Route::get('/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('categorias');
Route::post('/categoria/agregar', [App\Http\Controllers\CategoriaController::class, 'store'])->name('agregar-categoria');
Route::post('/categoria/buscar', [App\Http\Controllers\CategoriaController::class, 'show'])->name('buscar-categoria');
Route::post('/categoria/actualizar', [App\Http\Controllers\CategoriaController::class, 'update'])->name('actualizar-categoria');
Route::post('/categoria/borrar', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('borrar-categoria');