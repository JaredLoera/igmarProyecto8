<?php

namespace App\Http\Controllers;

class userController extends Controller
{
    public function verifyCodeView($email)
    {
        return view('/Code/verify-code', ['email' => $email]);
    }
    public function dashboardView()
    {
        return view('/Dashboard/index');
    }
    public function loginView()
    {
        return view('/Auth/index');
    }
    public function registerView()
    {
        return view('/Register/index');
    }
    
 
}
