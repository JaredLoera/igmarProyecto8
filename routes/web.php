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

/**
 * Ruta de error 500
 * 
 * Esta ruta se utiliza como fallback para errores internos del servidor.
 * Devuelve una vista de error 500 personalizada.
 */


/**
 * Ruta de error 403
 * 
 * Esta ruta se utiliza como fallback para errores de acceso denegado.
 * Devuelve una vista de error 403 personalizada.
 */

/**
 * Ruta de error 419
 * 
 * Esta ruta se utiliza como fallback para errores de expiración de sesión.
 * Devuelve una vista de error 419 personalizada.
 */

/**
 * Ruta de error 429
 * 
 * Esta ruta se utiliza como fallback para errores de demasiadas solicitudes.
 * Devuelve una vista de error 429 personalizada.
 */

/**
 * Ruta de error 503
 * 
 * Esta ruta se utiliza como fallback para errores de servicio no disponible.
 * Devuelve una vista de error 503 personalizada.
 */

/**
 * Ruta de error 401
 * 
 * Esta ruta se utiliza como fallback para errores de autenticación no autorizada.
 * Devuelve una vista de error 401 personalizada.
 */

Route::get('/401', function () {
    return response()->view('errors.401', [], 401);
})->name('401');
Route::get('/403', function () {
    return response()->view('errors.403', [], 403);
})->name('403');
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
Route::get('/419', function () {
    return response()->view('errors.419', [], 419);
})->name('419');
Route::get('/429', function () {
    return response()->view('errors.429', [], 429);
})->name('429');
Route::get('/500', function () {
    return response()->view('errors.500', [], 500);
})->name('500');
Route::get('/503', function () {
    return response()->view('errors.503', [], 503);
})->name('503');
