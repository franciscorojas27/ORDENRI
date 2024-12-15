<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Límite de Repetición de Contraseña al Cambiarla
    |--------------------------------------------------------------------------
    |
    | La cantidad de contraseñas anteriores que un usuario no puede repetir
    | al cambiar su contraseña. Esto ayuda a asegurar que el usuario
    | elija una nueva contraseña que no haya utilizado recientemente.
    |
    */
    'password_history_limit' => env('PASSWORD_HISTORY_LIMIT', 5),
    /*
    |--------------------------------------------------------------------------
    | Cantidad de intentos de login permitidos antes de bloquear la cuenta
    |--------------------------------------------------------------------------
    |
    | La cuenta se bloquea si el usuario intenta acceder con una clave incorrecta
    | la cantidad de veces especifica en este par metro.
    |
    */
    'login_max_attempts_before_block' => env('LOGIN_MAX_ATTEMPTS_BEFORE_BLOCK', 2),
    /*
    |--------------------------------------------------------------------------
    | Cantidad de intentos de login permitidos
    |--------------------------------------------------------------------------
    |
    | La cuenta se bloquea temporalmente si el usuario intenta acceder con una clave
    | incorrecta la cantidad de veces especifica en este par metro.
    |
    */
    'login_max_attempts' => env('LOGIN_MAX_ATTEMPTS', 5),
    /*
    |--------------------------------------------------------------------------
    | Titulo de trabajo predeterminado para los usuarios
    |--------------------------------------------------------------------------
    |
    | El id del titulo de trabajo que se asigna a los usuarios por defecto
    | cuando se crean y no se especifica el titulo de trabajo.
    |
    */
    'defaults_job_title' => env('DEFAULTS_JOB_TITLE', 1),
    'defaults_resolution_area' => env('DEFAULTS_RESOLUTION_AREA', 1),
    'defaults_passwords' => env('DEFAULTS_PASSWORDS', 'cantv1234'),
    /*
    |--------------------------------------------------------------------------
    | Tiempo de espera para desbloquear la cuenta
    |--------------------------------------------------------------------------
    |
    | El tiempo en minutos que debe esperar el usuario antes de que se desbloquee
    | la cuenta.
    |
    */
    'auth_unlock_expire' => env('AUTH_UNLOCK_EXPIRE', 60),
    /*
    |--------------------------------------------------------------------------
    | Días antes de notificar al usuario de que su contraseña va a caducar
    |--------------------------------------------------------------------------
    |
    | El número de días antes de que se notifique al usuario de que su contraseña
    | va a caducar. Si el par metro es 0, no se notificará al usuario.
    |
    */
    'days_before_notifying_password_expiration' => env('DAYS_BEFORE_NOTIFY_IF_CHANGE_YOUR_PASSWORD', 30),

];