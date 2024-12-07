<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Texto para el campo de fecha de inicio durante la edición
    |--------------------------------------------------------------------------
    |
    | Esta variable define el valor que se utilizará para el campo 'start_at' cuando
    | se encuentre en un estado de edición o no haya sido iniciado. Si no se define
    | un valor en el archivo `.env`, el valor por defecto será 'No iniciado'.
    |
    */
    'text_for_start_at_edit' => env('TEXT_FOR_START_AT_EDIT', 'No iniciado'),

    /*
        |--------------------------------------------------------------------------
        | Texto para el campo de fecha de finalización durante la edición
        |--------------------------------------------------------------------------
        |
        | Esta variable define el valor que se utilizará para el campo 'end_at' cuando
        | se encuentre en un estado de edición o no haya sido finalizado. Si no se define
        | un valor en el archivo `.env`, el valor por defecto será 'No finalizado'.
        |
        */
    'text_for_end_at_edit' => env('TEXT_FOR_END_AT_EDIT', 'No finalizado'),
];