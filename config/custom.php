<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Login Attempts Limits
    |--------------------------------------------------------------------------
    |
    | The maximum amount of times a user can attempt to login before
    | their account is locked for the specified amount of time.
    |
    */

    'login_max_attempts_before_block' => env('LOGIN_MAX_ATTEMPTS_BEFORE_BLOCK', 2),
    'login_max_attempts' => env('LOGIN_MAX_ATTEMPTS', 5),
    'defaults_job_title' => env('DEFAULTS_JOB_TITLE', 1)


];