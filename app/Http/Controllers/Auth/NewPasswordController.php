<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordRecords;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email','exists:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'unique_password_history'],
        ]);
        // Aquí intentaremos restablecer la contraseña del usuario. Si tiene éxito,
        // actualizaremos la contraseña en el modelo de usuario real y la guardaremos
        // en la base de datos. De lo contrario, analizaremos el error y devolveremos la respuesta.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password_may_expire_at' => Carbon::now(),
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
                PasswordRecords::addPasswordRecord($user, $request->password);
                event(new PasswordReset($user));
            }
        );
        // Si la contraseña a se restablecida  con  éxito, redirigiremos al usuario de vuelta
        // a la vista autenticada de la aplicación. Si hay un error, lo redirigiremos
        // de vuelta a donde estaban con su mensaje de error.
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
