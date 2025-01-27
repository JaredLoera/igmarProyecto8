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


// Rutas públicas
Route::get('', [userController::class, 'loginView']);
Route::get('/register', [userController::class, 'registerView']);
Route::get('/login', [userController::class, 'loginView'])->name('login');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [userController::class, 'dashboardView']);
    Route::post('/logout', [authController::class, 'logout']);
});


// Rutas para acciones (login, registro, verificación)
Route::post('/login', [authController::class, 'login']);
Route::post('/register', [authController::class, 'register']);
Route::post('/verify-code', [authController::class, 'verifyCode'])->name('verify.code.submit');

Route::get('/verify-code/{email}', [userController::class, 'verifyCodeView'])
->name('verify.code')
->middleware('signed'); // protegida con firma


//RUTA DE ERROR
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});