<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UniquePasswordHistory implements Rule
{
    /**
     * @var mixed
     * El usuario que se está validando.
     */
    protected $user;

    /**
     * @var int
     * El límite de contraseñas anteriores a comprobar.
     */
    protected $limit;

    /**
     * Crea una nueva instancia de la regla de validación.
     *
     * @param mixed|null $user El usuario que se está validando. Si no se pasa, se obtiene del request.
     * @param int|null $limit El número de contraseñas a verificar. Si no se pasa, se usa el valor de configuración.
     */
    public function __construct($user = null, $limit = null)
    {
        $this->user = $user ?? app('request')->user(); // El usuario que se va a validar (si no se pasa, se obtiene desde el request)
        $this->limit = $limit ?: config('custom.password_history_limit', 5); // Limite de contraseñas a revisar (valor por defecto: 5)
    }

    /**
     * Determina si la validación ha pasado.
     *
     * Verifica que la nueva contraseña no coincida con ninguna de las contraseñas anteriores del usuario.
     *
     * @param string $attribute El nombre del atributo que está siendo validado.
     * @param mixed $value El valor de la contraseña que se está validando.
     * @return bool `true` si la contraseña no coincide con ninguna de las anteriores, `false` si ya fue utilizada.
     */
    public function passes($attribute, $value)
    {
        // Si se pasa un usuario, se valida sus contraseñas anteriores
        if (is_null($this->user)) {
            $this->user = User::whereEmail(request()->input('email'))->first();
        }
        if ($this->user) {
            // Recuperamos las contraseñas anteriores del usuario, limitando la cantidad según el valor de $this->limit
            $passwords = $this->user->passwordRecords()
                ->latest() // Recupera las contraseñas más recientes
                ->take($this->limit) // Limita la cantidad de contraseñas a revisar
                ->pluck('password'); // Extrae solo las contraseñas

            // Comprobamos si la nueva contraseña ya está en el historial de contraseñas
            foreach ($passwords as $oldPassword) {
                if (Hash::check($value, $oldPassword)) {
                    return false; // La contraseña ya fue utilizada anteriormente
                }
            }
        }
        return true; // Si no hay coincidencias, pasa la validación
    }

    /**
     * Obtiene el mensaje de error que se mostrará si la validación falla.
     *
     * @return string El mensaje de error, que incluye el límite de contraseñas a comprobar.
     */
    public function message()
    {
        // Devuelve un mensaje personalizado con el límite de contraseñas configurado
        return __('validation.password_history', ['limit' => $this->limit]);
    }

    /**
     * Registrar la regla de validación personalizada y su mensaje de error.
     *
     * Este método registra la regla de validación `unique_password_history` para su uso en las validaciones,
     * así como el reemplazo del mensaje de error que se mostrará cuando la regla falle.
     */
    public static function registerValidationRule()
    {
        // Registrar la regla de validación
        Validator::extend('unique_password_history', function ($attribute, $value, $parameters, $validator) {
            // Obtenemos el usuario del request
            $user = app('request')->user();
            // Creamos una nueva instancia de la clase UniquePasswordHistory con el usuario
            $rule = new self($user);
            // Pasamos la validación y devolvemos el resultado
            return $rule->passes($attribute, $value);
        });

        // Personalizar el mensaje de error cuando la validación falle
        Validator::replacer('unique_password_history', function ($message, $attribute, $rule, $parameters) {
            // Creamos una nueva instancia de la clase UniquePasswordHistory para obtener el mensaje de error
            $rule = new self(null);
            // Devolvemos el mensaje de error generado
            return $rule->message();
        });
    }
}
