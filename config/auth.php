<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application.
    |
    */

    'defaults' => [
        'guard'     => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'students'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Define every authentication guard for your application. The "web" guard
    | uses session storage and the Eloquent user provider.
    |
    */

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'students',
        ],

        'api' => [
            'driver'   => 'token',
            'provider' => 'students',
            'hash'     => false,
        ],

        'employer' => [
            'driver'   => 'session',
            'provider' => 'employers',
        ],

        'admin' => [
            'driver'   => 'session',
            'provider' => 'admins',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Define how users are retrieved from your database.
    |
    */

    'providers' => [
        'students' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Student::class,
        ],

        'employers' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Employer::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Admin::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Configure password reset settings.
    |
    */

    'passwords' => [
        'students' => [
            'provider' => 'students',
            'table'    => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire'   => 60,
            'throttle' => 60,
        ],

        // If you have other brokers, add them here...
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Defines how long (in seconds) before a password confirmation times out.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
