<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Horario de Inicio y Fin de Trabajo
    |--------------------------------------------------------------------------
    |
    | Aquí puedes definir los valores del horario de trabajo, incluyendo la
    | hora de inicio y finalización. Estos valores son utilizados para calcular
    | las horas de trabajo en el sistema y establecer límites de tiempo.
    |
    */

    'start_time_at' => [
        /*
        |--------------------------------------------------------------------------
        | Minutos de Inicio de Trabajo
        |--------------------------------------------------------------------------
        |
        | Este valor define los minutos del inicio de la jornada laboral.
        | Por defecto, está configurado en 0, lo que significa que la jornada
        | laboral comienza a la hora exacta especificada por 'start_hours_work'.
        |
        | Ejemplo: Si se establece 30, la jornada comenzará a las 8:30 AM (si
        | 'start_hours_work' está configurado en 8).
        |
        */
        'start_minutes_work' => env('START_MINUTES_WORK', 0),  // Minutos de inicio del trabajo

        /*
        |--------------------------------------------------------------------------
        | Hora de Inicio de Trabajo
        |--------------------------------------------------------------------------
        |
        | Aquí defines la hora de inicio de la jornada laboral.
        | Por defecto, está configurado en 8:00 AM (08:00).
        |
        | Puedes modificar este valor a cualquier hora dentro del formato de 24 horas.
        |
        | Ejemplo: Si se establece 9, la jornada comenzará a las 9:00 AM.
        |
        */
        'start_hours_work' => env('START_HOURS_WORK', 8),  // Hora de inicio del trabajo
    ],

    'end_time_at' => [
        /*
        |--------------------------------------------------------------------------
        | Minutos de Fin de Trabajo
        |--------------------------------------------------------------------------
        |
        | Este valor define los minutos del fin de la jornada laboral.
        | Por defecto, está configurado en 30, lo que significa que la jornada
        | laboral terminará a los 30 minutos después de la hora especificada
        | por 'end_hours_work'.
        |
        | Ejemplo: Si se establece 45, la jornada terminará a las 4:45 PM (si
        | 'end_hours_work' está configurado en 16).
        |
        */
        'end_minutes_work' => env('END_MINUTES_WORK', 30),  // Minutos de fin del trabajo

        /*
        |--------------------------------------------------------------------------
        | Hora de Fin de Trabajo
        |--------------------------------------------------------------------------
        |
        | Aquí defines la hora de finalización de la jornada laboral.
        | Por defecto, está configurado en 4:00 PM (16:00).
        |
        | Puedes modificar este valor a cualquier hora dentro del formato de 24 horas.
        |
        | Ejemplo: Si se establece 17, la jornada finalizará a las 5:00 PM.
        |
        */
        'end_hours_work' => env('END_HOURS_WORK', 16),  // Hora de fin del trabajo
    ],
    /*
    |--------------------------------------------------------------------------
    | SLA (Service Level Agreement) Values
    |--------------------------------------------------------------------------
    |
    | En este archivo de configuración, definimos los valores de SLA (Acuerdo de 
    | Nivel de Servicio) utilizados en la aplicación. Estos valores definen 
    | los tiempos máximos permitidos para resolver ciertos tipos de solicitudes.
    | Los valores se obtienen desde las variables de entorno y permiten ser 
    | modificados sin necesidad de alterar el código fuente de la aplicación.
    |
    | Estos valores predeterminados sirven para configurar los SLA de 
    | soporte de mantenimiento y fallos. Si necesitas personalizar estos valores 
    | para tu entorno de producción, simplemente ajusta las variables de 
    | entorno correspondientes.
    |
    | 'sla_maintenance_support' - Define el SLA máximo permitido para el 
    |    soporte de mantenimiento, en horas. El valor predeterminado es 
    |    19.2 horas.
    | 'sla_fault'               - Define el SLA máximo permitido para fallos, 
    |    en horas. El valor predeterminado es 36 horas.
    |
    */
    'sla_values' => [
        /**
         * SLA para el soporte de mantenimiento. Define el tiempo máximo
         * permitido para resolver un ticket de mantenimiento en horas.
         * El valor predeterminado es 19.2 horas.
         *
         * Puedes modificar este valor en el archivo `.env` con la variable
         * `SLA_MAINTENANCE_SUPPORT`.
         */
        'sla_maintenance_support' => env('SLA_MAINTENANCE_SUPPORT', 19.2),

        /**
         * SLA para fallos. Define el tiempo máximo permitido para resolver un 
         * fallo o incidente en horas. El valor predeterminado es 36 horas.
         *
         * Puedes modificar este valor en el archivo `.env` con la variable 
         * `SLA_FAULT`.
         */
        'sla_fault' => env('SLA_FAULT', 36),
    ],
];
