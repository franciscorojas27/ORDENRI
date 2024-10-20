<?php

namespace App\Http\Requests\Auth;

use Carbon\Carbon;
use App\Models\User;
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
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8','max:20'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
{   
    $this->validationValuesLogin();
    $this->ensureIsNotRateLimited();

    if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
        RateLimiter::hit($this->throttleKey());        
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
    RateLimiter::clear('limit-login:' . Auth::user()->id);
    RateLimiter::clear($this->throttleKey());
}

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(),env('LOGIN_MAX_ATTEMPTS', 5))) {
            return;
        }
        $user = $this->userExists();

        if ($user && !$user->isBlocked()) {
            $user->update(['is_blocked' => true]);
            Mail::to($user->email)->send(new LockoutMail($this->ip()));
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle_block')
            ]);
        }    
    }    


    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
    protected function validationValuesLogin(){
        $user = User::whereEmail($this->string('email'))->first();
        match (true) {
            $user?->isDeleted() => throw ValidationException::withMessages([
                'email' => 'Esta cuenta no existe, si existe un problema con su cuenta por favor contacte con el administrador',
            ]),
            $user?->isBlocked() => throw ValidationException::withMessages([
                'email' => 'Su cuenta esta bloqueada',
            ]),
            $user?->atValidate() => throw ValidationException::withMessages([
                'email' => 'La clave no ha sido actualizada hace mas de 30 días',
            ]),
            default => null,
        };
    }
    
    protected function userExists()
    {
        return User::whereEmail($this->string('email'))->first();
    }
}
