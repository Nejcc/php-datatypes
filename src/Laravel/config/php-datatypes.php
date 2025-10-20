<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | PHP Datatypes Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for the PHP Datatypes
    | Laravel integration.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    |
    | Enable or disable automatic registration of validation rules.
    | When enabled, rules like 'int8', 'uint8', 'float32', etc. will be
    | automatically available in your validation.
    |
    */
    'auto_register_validation_rules' => true,

    /*
    |--------------------------------------------------------------------------
    | Default Error Messages
    |--------------------------------------------------------------------------
    |
    | Customize the default error messages for validation rules.
    | You can override these in your language files.
    |
    */
    'validation_messages' => [
        'int8' => 'The :attribute must be a valid 8-bit signed integer (-128 to 127).',
        'int16' => 'The :attribute must be a valid 16-bit signed integer (-32,768 to 32,767).',
        'int32' => 'The :attribute must be a valid 32-bit signed integer.',
        'int64' => 'The :attribute must be a valid 64-bit signed integer.',
        'uint8' => 'The :attribute must be a valid 8-bit unsigned integer (0 to 255).',
        'uint16' => 'The :attribute must be a valid 16-bit unsigned integer (0 to 65,535).',
        'uint32' => 'The :attribute must be a valid 32-bit unsigned integer.',
        'uint64' => 'The :attribute must be a valid 64-bit unsigned integer.',
        'float32' => 'The :attribute must be a valid 32-bit floating point number.',
        'float64' => 'The :attribute must be a valid 64-bit floating point number.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Eloquent Casts
    |--------------------------------------------------------------------------
    |
    | Enable automatic registration of Eloquent casts.
    | When enabled, casts like 'int8', 'uint8', 'float32', etc. will be
    | automatically available in your models.
    |
    */
    'auto_register_casts' => true,

    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    |
    | Configure performance-related settings for the library.
    |
    */
    'performance' => [
        /*
        |--------------------------------------------------------------------------
        | Enable Caching
        |--------------------------------------------------------------------------
        |
        | Enable caching of validation rules and casts for better performance.
        |
        */
        'enable_caching' => true,

        /*
        |--------------------------------------------------------------------------
        | Cache TTL
        |--------------------------------------------------------------------------
        |
        | Time to live for cached validation rules and casts in seconds.
        |
        */
        'cache_ttl' => 3600,
    ],
];
