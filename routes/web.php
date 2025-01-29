<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\authController;

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

/**
 * Rutas públicas
 * 
 * Estas rutas están protegidas por el middleware `guest`, lo que significa que solo están disponibles para usuarios no autenticados.
 */
Route::middleware(['guest'])->group(function () {
    // Vista de inicio de sesión
    Route::get('', [userController::class, 'loginView']);

    // Vista de registro
    Route::get('/register', [userController::class, 'registerView']);

    // Vista de inicio de sesión (con nombre de ruta 'login')
    Route::get('/login', [userController::class, 'loginView'])->name('login');

    // Proceso de inicio de sesión
    Route::post('/login', [authController::class, 'login']);

    // Proceso de registro
    Route::post('/register', [authController::class, 'register']);
});

/**
 * Rutas protegidas
 * 
 * Estas rutas están protegidas por el middleware `auth`, lo que significa que solo están disponibles para usuarios autenticados.
 */
Route::middleware(['auth'])->group(function () {
    // Vista del dashboard del usuario
    Route::get('/dashboard', [userController::class, 'dashboardView']);

    // Proceso de cierre de sesión
    Route::post('/logout', [authController::class, 'logout']);
});

/**
 * Rutas para acciones específicas
 * 
 * Estas rutas manejan acciones como la verificación de códigos, la verificación de correo y otras funcionalidades relacionadas.
 */

// Verificar un código enviado (formulario)
Route::post('/verify-code', [authController::class, 'verifyCode'])->name('verify.code.submit');

// Vista para la verificación de código con firma
Route::get('/verify-code/{email}', [userController::class, 'verifyCodeView'])
    ->name('verify.code')
    ->middleware('signed'); // Protegida con firma para mayor seguridad

// Procesar la verificación de correo electrónico
Route::get('/email/verify/{id}', [AuthController::class, 'verifyEmail'])
    ->name('email.verify')
    ->middleware('signed'); // Protegida con firma para prevenir manipulaciones

/**
 * Ruta de error 404
 * 
 * Esta ruta se utiliza como fallback cuando ninguna de las rutas anteriores coincide.
 * Devuelve una vista de error 404 personalizada.
 */
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});