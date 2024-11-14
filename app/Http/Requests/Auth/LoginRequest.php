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
            'userid' => ['required', 'string', 'max:8','exists:users,userid'],
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

    protected function checkRateLimits(): void
    {
        $maxAttempts = config('custom.login_max_attempts', 5);

        if (
            RateLimiter::tooManyAttempts($this->throttleKeyIp(), $maxAttempts) ||
            RateLimiter::tooManyAttempts($this->throttleKeyEmail(), $maxAttempts)
        ) {

            $user = $this->userExists();

            if ($user && !$user->isBlocked()) {
                $user->update(['is_blocked' => true]);
                Mail::to($user->email)->send(new LockoutMail(Order::all()));
            }

            throw ValidationException::withMessages([
                'userid' => trans('auth.throttle_block'),
            ]);
        }
    }


    // original del rate limited 
    // public function ensureIsNotRateLimited(): void
    // {
    //     if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
    //         return;
    //     }

    //     event(new Lockout($this));

    //     $seconds = RateLimiter::availableIn($this->throttleKey());

    //     throw ValidationException::withMessages([
    //         'email' => trans('auth.throttle', [
    //             'seconds' => $seconds,
    //             'minutes' => ceil($seconds / 60),
    //         ]),
    //     ]);
    // }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKeyEmail(): string
    {
        return Str::transliterate(Str::lower($this->email));
    }

    public function throttleKeyIp(): string
    {
        return Str::transliterate($this->ip());
    }
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
                'userid' => 'La clave no ha sido actualizada hace más de 30 días',
            ]);
        }
        return null;
    }


    protected function userExists()
    {
        return User::whereEmail($this->email)->first();
    }
}
