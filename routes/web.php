<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EscuadronController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UserController;
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

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [LoginController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');




Route::group(['middleware' => 'auth'], function () {
    //asistencia
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::post('/', [DashboardController::class, 'post'])
        ->name('dashboardSave');
    //users
    Route::get('users', [UserController::class, 'getAll'])
        ->name('listaUsuarios');
    Route::post('user', [UserController::class, 'post'])
        ->name('guardarUsuarios');
    Route::delete('user/{id}', [UserController::class, 'borrar'])
        ->name('eliminarUsuarios');
    //personas
    Route::get('persona', [PersonaController::class, 'getAll'])
        ->name('listaPersonas');
    Route::post('persona', [PersonaController::class, 'post'])
        ->name('guardarPersona');
    Route::delete('persona/{id}', [PersonaController::class, 'borrar'])
        ->name('eliminarPersona');
    //escuadron
    Route::get('escuadron', [EscuadronController::class, 'getAll'])
        ->name('listaEscuadrones');
    Route::post('escuadron', [EscuadronController::class, 'post'])
        ->name('guardarEscuadrones');
    Route::delete('escuadron/{id}', [EscuadronController::class, 'borrar'])
        ->name('eliminarEscuadrones');
    //reporte
    Route::get('reporte', [ReporteController::class, 'index'])
        ->name('reporte');
});

