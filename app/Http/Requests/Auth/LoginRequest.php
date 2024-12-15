<?php

namespace App\Http\Requests\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Mail\LockoutMail;
use Illuminate\Support\Str;
use App\Events\UserLockedOut;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Notifications\AccountLockedNotification;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'email' => ['required', 'string', 'email'],
            'userid' => ['required', 'string', 'max:8', 'exists:users,userid'],
            'password' => ['required', 'string', 'min:8', 'max:20'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'userid' => 'usuario',
        ];
    }
    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $user = User::where('userid', $this->input('userid'))->first();

        if ($user) {
            $this->merge(['email' => $user->email]);
        }
        $this->validationValuesLogin($user);
        $this->checkRateLimits();
        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKeyIp());
            RateLimiter::hit($this->throttleKeyEmail());
            if (config('custom.login_max_attempts_before_block', 3) == RateLimiter::attempts($this->throttleKeyIp())) {
                throw ValidationException::withMessages([
                    'userid' => trans('auth.throttle_login_before_block', [
                        'intentos' => config('custom.login_max_attempts', 5) - config('custom.login_max_attempts_before_block', 3),
                    ]),
                ]);
            }

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        RateLimiter::clear($this->throttleKeyIp());
        RateLimiter::clear($this->throttleKeyEmail());
    }
    /**
     * Comprueba si el usuario ha excedido el límite de intentos de inicio de sesión.
     *
     * Si el usuario ha excedido el límite de intentos, se bloquea su cuenta y se envía un correo electrónico con la lista de pedidos.
     *
     * @return void
     */
    protected function checkRateLimits(): void
    {
        $maxAttempts = config('custom.login_max_attempts', 5);

        if (
            RateLimiter::tooManyAttempts($this->throttleKeyIp(), $maxAttempts) ||
            RateLimiter::tooManyAttempts($this->throttleKeyEmail(), $maxAttempts)
        ) {

            $user = User::where('userid', $this->input('userid'))->first();

            if ($user && !$user->isBlocked()) {
                $user->notify(new AccountLockedNotification($user));
                $user->update(['is_blocked' => true]);

            }

            throw ValidationException::withMessages([
                'userid' => trans('auth.throttle_block'),
            ]);
        }
    }
    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKeyEmail(): string
    {
        return Str::transliterate(Str::lower($this->email));
    }
    /**
     * Genera una clave de limitador de velocidad para la petición que se basa en la IP del usuario.
     *
     * @return string
     */
    public function throttleKeyIp(): string
    {
        return Str::transliterate($this->ip());
    }
    /**
     * Verifica si el usuario ha sido eliminado, si su cuenta está bloqueada o si
     * la contraseña ha caducado y lanza una excepción con mensajes de error
     * correspondientes.
     *
     * @param User $user
     * @return void
     * @throws ValidationException
     */
    protected function validationValuesLogin(User $user)
    {
        if ($user?->isDeleted()) {
            throw ValidationException::withMessages([
                'userid' => 'Esta cuenta no existe, si existe un problema con su cuenta por favor contacte con el administrador',
            ]);
        }
        if ($user?->isBlocked()) {
            throw ValidationException::withMessages([
                'userid' => 'Su cuenta está bloqueada',
            ]);
        }
        if ($user?->atValidate()) {
            throw ValidationException::withMessages([
                'userid' => 'La clave no ha sido actualizada hace más de ' . config('custom.days_before_notifying_password_expiration', 30) . ' días, restablezca su contraseña para seguir.',
            ]);
        }
    }
}
