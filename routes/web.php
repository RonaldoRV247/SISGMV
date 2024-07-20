<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\ReparacionesController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\VehiculosController;
use App\Http\Controllers\MantenimientosController;
use App\Http\Controllers\MaquinariasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('role:administrador');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    

        Route::get('users/{userId}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('role:administrador');
        Route::post('users/{userId}/update-roles', [UserController::class, 'updateRoles'])->name('users.updateRoles')->middleware('role:administrador');
        Route::post('users', [UserController::class, 'store'])->name('users.store')->middleware('role:administrador');
        Route::delete('users/{userId}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('role:administrador');
        Route::post('users/{userId}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword')->middleware('auth');

        Route::get('home/datatable', [HomeController::class, 'vehiculosDatatable'])->name('home.datatable')->middleware('role:administrador|usuario|visualizador');
        Route::post('home/print', [HomeController::class, 'print'])->middleware('role:administrador|usuario|visualizador');
        Route::get('home/obtener_datos_grafico', [HomeController::class, 'obtenerDatosGrafico'])->middleware('role:administrador|usuario|visualizador');
        Route::get('home/obtener_datos_grafico2', [HomeController::class, 'obtenerDatosGrafico2'])->middleware('role:administrador|usuario|visualizador')->middleware('role:administrador|usuario|visualizador');
        Route::get('home/obtener_vehiculos_reincidentes', [HomeController::class, 'obtenerVehiculosReincidentes'])->middleware('role:administrador|usuario|visualizador');
        Route::get('home/obtener_reparaciones_frecuentes', [HomeController::class, 'obtenerReparacionesFrecuentes'])->middleware('role:administrador|usuario|visualizador');
        Route::get('home/obtener_promedio_precios_reparaciones', [HomeController::class, 'obtenerPromedioPreciosReparaciones'])->middleware('role:administrador|usuario|visualizador');

        // Rutas para vistas de proveedores
        Route::get('proveedores', [ProveedoresController::class, 'index'])->middleware('role:administrador|usuario|visualizador');
        Route::post('proveedores/store', [ProveedoresController::class, 'store'])->middleware('role:administrador|usuario');
        Route::post('proveedores/edit', [ProveedoresController::class, 'edit'])->middleware('role:administrador|usuario');
        Route::post('proveedores/delete', [ProveedoresController::class, 'destroy'])->middleware('role:administrador|usuario');
        Route::post('proveedores/print', [ProveedoresController::class, 'print'])->middleware('role:administrador|usuario|visualizador');

        // Rutas para vistas de reparaciones
        Route::get('reparaciones', [ReparacionesController::class, 'index'])->middleware('role:administrador|usuario|visualizador');
        Route::post('reparaciones/store', [ReparacionesController::class, 'store'])->middleware('role:administrador|usuario');
        Route::post('reparaciones/edit', [ReparacionesController::class, 'edit'])->middleware('role:administrador|usuario');
        Route::post('reparaciones/delete', [ReparacionesController::class, 'destroy'])->middleware('role:administrador|usuario');
        Route::post('reparaciones/print', [ReparacionesController::class, 'print'])->middleware('role:administrador|usuario|visualizador');

        // Rutas para vistas de personas
        Route::get('personas', [PersonasController::class, 'index'])->middleware('role:administrador|usuario|visualizador');
        Route::post('personas/store', [PersonasController::class, 'store'])->middleware('role:administrador|usuario');
        Route::post('personas/edit', [PersonasController::class, 'edit'])->middleware('role:administrador|usuario');
        Route::post('personas/delete', [PersonasController::class, 'destroy'])->middleware('role:administrador|usuario');
        Route::post('personas/print', [PersonasController::class, 'print'])->middleware('role:administrador|usuario|visualizador');

        // Rutas para vistas de vehículos
        Route::get('vehiculos', [VehiculosController::class, 'index'])->middleware('role:administrador|usuario|visualizador');
        Route::post('vehiculos/store', [VehiculosController::class, 'store'])->middleware('role:administrador|usuario');
        Route::post('vehiculos/edit', [VehiculosController::class, 'edit'])->middleware('role:administrador|usuario');
        Route::post('vehiculos/delete', [VehiculosController::class, 'destroy'])->middleware('role:administrador|usuario');
        Route::post('vehiculos/print', [VehiculosController::class, 'print'])->middleware('role:administrador|usuario|visualizador');

        // Rutas para vistas de maquinarias
        Route::get('maquinarias', [MaquinariasController::class, 'index'])->middleware('role:administrador|usuario|visualizador');
        Route::post('maquinarias/store', [MaquinariasController::class, 'store'])->middleware('role:administrador|usuario');
        Route::post('maquinarias/edit', [MaquinariasController::class, 'edit'])->middleware('role:administrador|usuario');
        Route::post('maquinarias/delete', [MaquinariasController::class, 'destroy'])->middleware('role:administrador|usuario');
        Route::post('maquinarias/print', [MaquinariasController::class, 'print'])->middleware('role:administrador|usuario|visualizador');

        // Rutas para vistas de mantenimientos
        Route::get('mantenimientos', [MantenimientosController::class, 'index'])->middleware('role:administrador|usuario|visualizador');
        Route::post('mantenimientos/store', [MantenimientosController::class, 'store'])->middleware('role:administrador|usuario');
        Route::post('mantenimientos/edit', [MantenimientosController::class, 'edit'])->middleware('role:administrador|usuario');
        Route::post('mantenimientos/delete', [MantenimientosController::class, 'destroy'])->middleware('role:administrador|usuario');
        Route::post('mantenimientos/print', [MantenimientosController::class, 'print'])->middleware('role:administrador|usuario|visualizador');
        Route::post('mantenimientos/printgen', [MantenimientosController::class, 'printgen'])->middleware('role:administrador|usuario|visualizador');
});
