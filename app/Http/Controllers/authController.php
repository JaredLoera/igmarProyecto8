<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Code;
use Illuminate\Support\Facades\Log;


use App\Mail\sendMailCode;

class authController extends Controller
{
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:4'],
        ]);
        $lastCode = Code::where('user_id', Auth::id())->latest()->first();
        if ($lastCode->code == $request->code) {
            // Regenerar sesión y autenticar completamente
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['code' => 'El código ingresado es incorrecto.']);
    }
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'phone' => 'required|numeric|digits:10'
            ],
            [
                'email.required' => 'El email es requerido',
                'email.email' => 'El email debe ser un email valido',
                'email.unique' => 'El email ya esta registrado',
                'password.required' => 'La contraseña es requerida',
                'phone.required' => 'El telefono es requerido',
                'phone.numeric' => 'El telefono debe ser numerico',
                'phone.digits' => 'El telefono debe tener 10 digitos'
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        Log::debug($user);
        if ($user->save()) {
            return redirect()->route('login');
        } else {
            Log::error('User not saved', ['user' => $user]);
            return back()->withErrors([
                "errors"
            ])->onlyInput('email');
        }
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $random = rand(1000, 9999);
        if (Auth::validate($credentials)) {
            $user = Auth::user();
            $code = new code();
            $code->code = $random;
            $code->user_id = $user->id;
            $code->save();
            Mail::to($request->email)->send(new sendMailCode($random));
            $signedUrl = URL::temporarySignedRoute(
                'verify.code',
                now()->addMinutes(15),
                ['email' => $request->email]
            );
            // Redirigir al usuario a la vista de verificación
            return redirect($signedUrl);
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
