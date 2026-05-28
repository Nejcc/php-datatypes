<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Laravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Nejcc\PhpDatatypes\Laravel\Validation\Rules\Int8Rule;
use Nejcc\PhpDatatypes\Laravel\Validation\Rules\Int16Rule;
use Nejcc\PhpDatatypes\Laravel\Validation\Rules\Int32Rule;
use Nejcc\PhpDatatypes\Laravel\Validation\Rules\Int64Rule;
use Nejcc\PhpDatatypes\Laravel\Validation\Rules\UInt8Rule;
use Nejcc\PhpDatatypes\Laravel\Validation\Rules\UInt16Rule;
use Nejcc\PhpDatatypes\Laravel\Validation\Rules\UInt32Rule;
use Nejcc\PhpDatatypes\Laravel\Validation\Rules\UInt64Rule;
use Nejcc\PhpDatatypes\Laravel\Validation\Rules\Float32Rule;
use Nejcc\PhpDatatypes\Laravel\Validation\Rules\Float64Rule;

/**
 * Laravel Service Provider for PHP Datatypes
 */
class PhpDatatypesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register any services here if needed
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerValidationRules();
    }

    /**
     * Register custom validation rules
     */
    private function registerValidationRules(): void
    {
        // Integer validation rules
        Validator::extend('int8', Int8Rule::class);
        Validator::extend('int16', Int16Rule::class);
        Validator::extend('int32', Int32Rule::class);
        Validator::extend('int64', Int64Rule::class);
        Validator::extend('uint8', UInt8Rule::class);
        Validator::extend('uint16', UInt16Rule::class);
        Validator::extend('uint32', UInt32Rule::class);
        Validator::extend('uint64', UInt64Rule::class);

        // Float validation rules
        Validator::extend('float32', Float32Rule::class);
        Validator::extend('float64', Float64Rule::class);

        // Add custom error messages
        $this->addValidationMessages();
    }

    /**
     * Add custom validation error messages
     */
    private function addValidationMessages(): void
    {
        $messages = [
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
        ];

        foreach ($messages as $rule => $message) {
            Validator::replacer($rule, function ($message, $attribute, $rule, $parameters) {
                return str_replace(':attribute', $attribute, $message);
            });
        }
    }
}
