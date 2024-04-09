<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\ReparacionesController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\VehiculosController;
use App\Http\Controllers\MantenimientosController;
use App\Http\Controllers\DetallesMantenimientoController;
use App\Http\Controllers\HomeController;

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


Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
//Rutas para home
Route::get('home/datatable', [HomeController::class, 'vehiculosDatatable'])->name('home.datatable');
Route::post('home/print',[HomeController::class,'print'])->middleware('web');
Route::get('home/obtener_datos_grafico',[HomeController::class,'obtenerDatosGrafico'])->middleware('web');
Route::get('home/obtener_datos_grafico2',[HomeController::class,'obtenerDatosGrafico2'])->middleware('web');
//Rutas para vistas de proveedores
Route::get('proveedores', [ProveedoresController::class, 'index']);
Route::post('proveedores/store', [ProveedoresController::class, 'store'])->middleware('web');
Route::post('proveedores/edit', [ProveedoresController::class, 'edit'])->middleware('web');
Route::post('proveedores/delete', [ProveedoresController::class, 'destroy'])->middleware('web');
Route::post('proveedores/print', [ProveedoresController::class, 'print'])->middleware('web');

//Rutas para vistas de reparaciones
Route::get('reparaciones', [ReparacionesController::class, 'index']);
Route::post('reparaciones/store', [ReparacionesController::class, 'store'])->middleware('web');
Route::post('reparaciones/edit', [ReparacionesController::class, 'edit'])->middleware('web');
Route::post('reparaciones/delete', [ReparacionesController::class, 'destroy'])->middleware('web');
Route::post('reparaciones/print',[ReparacionesController::class,'print'])->middleware('web');

//Rutas para vistas de personas
Route::get('personas', [PersonasController::class, 'index']);
Route::post('personas/store', [PersonasController::class, 'store'])->middleware('web');
Route::post('personas/edit', [PersonasController::class, 'edit'])->middleware('web');
Route::post('personas/delete', [PersonasController::class, 'destroy'])->middleware('web');
Route::post('personas/print', [PersonasController::class, 'print'])->middleware('web');

//Rutas para vistas de vehiculos
Route::get('vehiculos', [VehiculosController::class, 'index']);
Route::post('vehiculos/store', [VehiculosController::class, 'store'])->middleware('web');
Route::post('vehiculos/edit', [VehiculosController::class, 'edit'])->middleware('web');
Route::post('vehiculos/delete', [VehiculosController::class, 'destroy'])->middleware('web');
Route::post('vehiculos/print', [VehiculosController::class, 'print'])->middleware('web');

//Rutas para vistas de mantenimientos
Route::get('mantenimientos', [MantenimientosController::class, 'index']);
Route::post('mantenimientos/store', [MantenimientosController::class, 'store'])->middleware('web');
Route::post('mantenimientos/edit', [MantenimientosController::class, 'edit'])->middleware('web');
Route::post('mantenimientos/delete', [MantenimientosController::class, 'destroy'])->middleware('web');
Route::post('mantenimientos/print', [MantenimientosController::class, 'print'])->middleware('web');
Route::post('mantenimientos/printgen', [MantenimientosController::class, 'printgen'])->middleware('web');
});
