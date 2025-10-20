# PHP Datatypes Laravel Integration

This package provides seamless integration between PHP Datatypes and Laravel, including validation rules, Eloquent casts, and form requests.

## Installation

1. Install the package via Composer:
```bash
composer require nejcc/php-datatypes
```

2. Register the service provider in your `config/app.php`:
```php
'providers' => [
    // ...
    Nejcc\PhpDatatypes\Laravel\PhpDatatypesServiceProvider::class,
],
```

3. Publish the configuration file (optional):
```bash
php artisan vendor:publish --provider="Nejcc\PhpDatatypes\Laravel\PhpDatatypesServiceProvider"
```

## Validation Rules

The package automatically registers validation rules for all PHP Datatypes:

### Integer Types
- `int8` - 8-bit signed integer (-128 to 127)
- `int16` - 16-bit signed integer (-32,768 to 32,767)
- `int32` - 32-bit signed integer
- `int64` - 64-bit signed integer
- `uint8` - 8-bit unsigned integer (0 to 255)
- `uint16` - 16-bit unsigned integer (0 to 65,535)
- `uint32` - 32-bit unsigned integer
- `uint64` - 64-bit unsigned integer

### Floating Point Types
- `float32` - 32-bit floating point number
- `float64` - 64-bit floating point number

### Usage in Form Requests

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'age' => ['required', 'int8'],
            'user_id' => ['required', 'uint8'],
            'balance' => ['required', 'float32'],
        ];
    }
}
```

### Usage in Controllers

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'age' => ['required', 'int8'],
            'user_id' => ['required', 'uint8'],
        ]);

        $age = new Int8($request->input('age'));
        $userId = new UInt8($request->input('user_id'));

        // Use the type-safe values...
    }
}
```

## Eloquent Casts

You can use PHP Datatypes as Eloquent casts:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nejcc\PhpDatatypes\Laravel\Casts\Int8Cast;

class User extends Model
{
    protected $casts = [
        'age' => Int8Cast::class,
        'user_id' => 'uint8', // Custom cast
        'balance' => 'float32', // Custom cast
    ];
}
```

### Custom Casts

You can create custom casts for your models:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;

class User extends Model
{
    public function getAgeAttribute($value): Int8
    {
        return new Int8($value);
    }

    public function setAgeAttribute($value): void
    {
        if ($value instanceof Int8) {
            $this->attributes['age'] = $value->getValue();
        } else {
            $this->attributes['age'] = $value;
        }
    }
}
```

## Form Requests

The package includes example form requests that demonstrate proper usage:

```php
<?php

namespace App\Http\Requests;

use Nejcc\PhpDatatypes\Laravel\Http\Requests\PhpDatatypesFormRequest;

class MyFormRequest extends PhpDatatypesFormRequest
{
    public function rules(): array
    {
        return [
            'age' => ['required', 'int8'],
            'user_id' => ['required', 'uint8'],
            'balance' => ['required', 'float32'],
        ];
    }
}
```

## Controllers

Example controller showing various usage patterns:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Composite\Option;
use Nejcc\PhpDatatypes\Composite\Result;

class ExampleController extends Controller
{
    public function handleOptionalData(Request $request)
    {
        $optionalValue = Option::fromNullable($request->input('optional_field'));

        $result = $optionalValue
            ->map(fn($value) => strtoupper($value))
            ->unwrapOr('DEFAULT_VALUE');

        return response()->json([
            'processed_value' => $result,
            'was_present' => $optionalValue->isSome(),
        ]);
    }

    public function safeOperation(Request $request)
    {
        $result = Result::try(function () use ($request) {
            $value = $request->input('value');
            if (!is_numeric($value)) {
                throw new \InvalidArgumentException('Value must be numeric');
            }
            return new Int8((int) $value);
        });

        if ($result->isOk()) {
            $int8 = $result->unwrap();
            return response()->json([
                'success' => true,
                'value' => $int8->getValue(),
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => $result->unwrapErr()->getMessage(),
        ], 400);
    }
}
```

## Configuration

You can customize the behavior by publishing and modifying the configuration file:

```php
// config/php-datatypes.php

return [
    'auto_register_validation_rules' => true,
    'auto_register_casts' => true,
    'validation_messages' => [
        'int8' => 'Custom message for int8 validation',
        // ...
    ],
];
```

## Error Messages

Customize validation error messages in your language files:

```php
// resources/lang/en/validation.php

return [
    'int8' => 'The :attribute must be a valid 8-bit signed integer.',
    'uint8' => 'The :attribute must be a valid 8-bit unsigned integer.',
    // ...
];
```

## Examples

See the example files in the `src/Laravel/` directory for complete working examples:

- `Http/Controllers/PhpDatatypesController.php` - Controller examples
- `Http/Requests/PhpDatatypesFormRequest.php` - Form request examples
- `Models/ExampleModel.php` - Model examples
- `Casts/Int8Cast.php` - Custom cast examples

## Best Practices

1. **Use Form Requests**: Always use form requests for validation to keep your controllers clean.

2. **Type Safety**: Leverage the type safety provided by PHP Datatypes to prevent runtime errors.

3. **Error Handling**: Use the `Result` type for operations that might fail.

4. **Nullable Values**: Use the `Option` type for handling nullable values safely.

5. **Arithmetic Operations**: Use the built-in arithmetic methods to prevent overflow/underflow.

## Troubleshooting

### Common Issues

1. **Validation Rules Not Found**: Make sure the service provider is registered.

2. **Cast Errors**: Ensure your database columns can store the expected values.

3. **Overflow/Underflow**: Use the appropriate integer type for your data range.

### Debug Mode

Enable debug mode in your configuration to see detailed error messages:

```php
// config/php-datatypes.php
'debug' => true,
```
