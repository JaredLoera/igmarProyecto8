<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Code;
use Illuminate\Support\Facades\Hash;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\Http;


use App\Mail\sendMailCode;

class authController extends Controller
{
    /**
 * Verifica el correo electrónico de un usuario a través de una URL firmada.
 *
 * @param \Illuminate\Http\Request $request
 * @param int $id ID del usuario.
 * @return \Illuminate\Http\RedirectResponse
 */
public function verifyEmail(Request $request, $id)
{
    // Verifica si la URL firmada es válida
    if (!$request->hasValidSignature()) {
        abort(403, 'La URL de verificación es inválida o ha expirado.');
    }

    // Busca al usuario por ID
    $user = User::findOrFail($id);

    // Verifica si el correo ya fue verificado
    if ($user->email_verified_at) {
        return redirect()->route('login')->with('status', 'El correo ya fue verificado anteriormente.');
    }

    // Marca el correo como verificado
    $user->email_verified_at = now();
    $user->save();

    return redirect()->route('login')->with('status', 'Correo verificado exitosamente. Ahora puedes iniciar sesión.');
}

/**
 * Verifica un código de 4 dígitos enviado por correo electrónico.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function verifyCode(Request $request)
{
    // Valida la solicitud
    $request->validate([
        'email' => ['required', 'email'],
        'code' => ['required', 'digits:4'],
    ]);

    // Busca al usuario por correo electrónico
    $user = User::where('email', $request->email)->first();
    $lastCode = Code::where('user_id', $user->id)->latest()->first();

    // Verifica el código
    if (Hash::check($request->code, $lastCode->code)) {
        $lastCode->is_used = true;
        $lastCode->save();

        // Inicia sesión y redirige al dashboard
        Auth::login($user);
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors(['code' => 'El código ingresado es incorrecto.']);
}

/**
 * Proceso de inicio de sesión con envío de un código de verificación.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function login(Request $request)
{
    // Valida las credenciales
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => config('services.recaptcha.secret_key'),
        'response' => $request->input('g-recaptcha-response'),
    ]);

    $responseBody = $response->json();

    if (!$responseBody['success']) {
        return back()->withErrors(['g-recaptcha-response' => 'Error al validar el reCAPTCHA.']);
    }
   
    // Genera un código aleatorio de 4 dígitos
    $random = rand(1000, 9999);
    // Verifica las credenciales
    if (Auth::validate($credentials)) {
        $user = User::where('email', $request->email)->first();
        // Guarda el código de verificación en la base de datos
        if (!$user->email_verified_at) {
            return redirect()->route('login')->with('status', 'Tu correo no está verificado. Por favor verifica tu correo antes de continuar.');
        }
        $code = new Code();
        $code->code = bcrypt($random);
        $code->user_id = $user->id;
        $code->save();

        // Envía el código por correo electrónico
        Mail::to($request->email)->send(new sendMailCode($random));

        // Genera una URL firmada para la verificación del código
        $signedUrl = URL::temporarySignedRoute(
            'verify.code',
            now()->addMinutes(15),
            ['email' => $request->email]
        );

        return redirect($signedUrl);
    }
    return back()->withErrors(['email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.']);
}

/**
 * Registra un nuevo usuario y envía un correo de verificación.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function register(Request $request)
{
    //correo de prueba "salazarloerajared@gmail.com"
    // Valida los datos de entrada
    $validator = Validator::make(
        $request->all(),
        [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'g-recaptcha-response' => 'required', // Validar que el captcha esté presente
        ],
        [
            'email.required' => 'El email es requerido',
            'email.email' => 'El email debe ser un email válido',
            'email.unique' => 'El email ya está registrado',
            'password.required' => 'La contraseña es requerida',
        ]
    );
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => config('services.recaptcha.secret_key'),
        'response' => $request->input('g-recaptcha-response'),
    ]);

    $responseBody = $response->json();

    if (!$responseBody['success']) {
        return back()->withErrors(['g-recaptcha-response' => 'Error al validar el reCAPTCHA.']);
    }
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Crea un nuevo usuario
    $user = new User();
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->phone = $request->phone;

    if ($user->save()) {
        // Genera una URL firmada para la verificación del correo
        $signedUrl = URL::temporarySignedRoute(
            'email.verify',
            now()->addMinutes(60),
            ['id' => $user->id]
        );

        // Envía el correo de verificación
        Mail::to($user->email)->send(new EmailVerificationMail($signedUrl));
        return redirect()->route('login')->with('status', 'Se envió un correo de verificación.');
    }
    return back()->withErrors(['error' => 'No se pudo completar el registro.'])->onlyInput('email');
}

/**
 * Cierra la sesión del usuario.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
}
}
