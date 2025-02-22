<?php

namespace App\Http\Controllers;

class userController extends Controller
{
    /**
     * Muestra la vista de registro, verificar codigo, index de dashboard, index de login, index de register.
     *
     * Este método carga la plantilla donde los usuarios pueden ingresar sus datos para crear una nueva cuenta.
     *
     * @return \Illuminate\View\View
     */
    public function verifyCodeView($email)
    {
        return view('Code/verify-code', ['email' => $email]);
    }
    public function dashboardView()
    {
        return view('Dashboard/index');
    }
    public function loginView()
    {
        return view('Auth/index');
    }
    public function registerView()
    {
        return view('Register/index');
    }
    
 
}
