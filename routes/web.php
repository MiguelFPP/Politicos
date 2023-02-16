<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExcelFormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('inicio'));
});
Auth::routes(['register' => false]);


Route::middleware(['auth'])->group(function () {
    Route::get('/util/usuarios', [Controller::class, 'lista_usuarios'])->name('util.lista_usuarios');

    Route::get('/inicio', [HomeController::class, 'index'])->name('inicio');

    Route::get('/formularios', [FormularioController::class, 'index'])->name('formularios');
    Route::get('/formularios/tabla', [FormularioController::class, 'tabla'])->name('formularios.tabla');
    Route::get('/formularios/crear', [FormularioController::class, 'crear'])->name('formularios.crear');
    Route::post('/formularios/crear', [FormularioController::class, 'crear_guardar'])->name('formularios.crear.guardar');
    Route::get('/formularios/{id}/ver', [FormularioController::class, 'ver'])->name('formularios.ver');
    Route::get('/formularios/{id}/actualizar', [FormularioController::class, 'actualizar'])->name('formularios.actualizar');
    Route::post('/formularios/{id}/actualizar', [FormularioController::class, 'actualizar_guardar'])->name('formularios.actualizar.guardar');
    Route::get('/formularios/{id}/eliminar', [FormularioController::class, 'eliminar'])->name('formularios.eliminar');
    Route::get('/formularios/{id}/eliminar/conf', [FormularioController::class, 'eliminar_confirmar'])->name('formularios.eliminar.confirmar');
    Route::get('/forms-all', [FormularioController::class, 'allForms'])->name('forms.all');

    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios');
    Route::get('/usuarios/tabla', [UsuarioController::class, 'tabla'])->name('usuarios.tabla');
    Route::get('/usuarios/crear', [UsuarioController::class, 'crear'])->name('usuarios.crear');
    Route::post('/usuarios/crear', [UsuarioController::class, 'crear_guardar'])->name('usuarios.crear.guardar');
    Route::get('/usuarios/{id}/ver', [UsuarioController::class, 'ver'])->name('usuarios.ver');
    Route::get('/usuarios/{id}/actualizar', [UsuarioController::class, 'actualizar'])->name('usuarios.actualizar');
    Route::post('/usuarios/{id}/actualizar', [UsuarioController::class, 'actualizar_guardar'])->name('usuarios.actualizar.guardar');
    Route::get('/usuarios/{id}/eliminar', [UsuarioController::class, 'eliminar'])->name('usuarios.eliminar');
    Route::get('/usuarios/{id}/eliminar/conf', [UsuarioController::class, 'eliminar_confirmar'])->name('usuarios.eliminar.confirmar');

    Route::prefix('location')->group(function () {
        Route::get('quarters/{commune_id}', [LocationController::class, 'getQuarters'])->name('location.quarters');
        Route::get('sidewalks/{township_id}', [LocationController::class, 'getSidewalks'])->name('location.sidewalks');
    });

    /* for export excel */
    Route::get('/excel-forms', [ExcelFormController::class, 'exportForms'])->name('excel.forms');
});
