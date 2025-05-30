# PHP Datatypes: Strict, Safe, and Flexible Data Handling for PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nejcc/php-datatypes.svg?style=flat-square)](https://packagist.org/packages/nejcc/php-datatypes)
[![Total Downloads](https://img.shields.io/packagist/dt/nejcc/php-datatypes.svg?style=flat-square)](https://packagist.org/packages/nejcc/php-datatypes)
![GitHub Actions](https://github.com/nejcc/php-datatypes/actions/workflows/main.yml/badge.svg)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=bugs)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)
[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=ncloc)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)

---

## Overview

**PHP Datatypes** is a robust library that brings strict, safe, and expressive data type handling to PHP. It provides a comprehensive set of scalar and composite types, enabling you to:
- Enforce type safety and value ranges
- Prevent overflows, underflows, and type juggling bugs
- Serialize and deserialize data with confidence
- Improve code readability and maintainability
- Build scalable and secure applications with ease
- Integrate seamlessly with modern PHP frameworks and tools
- Leverage advanced features like custom types, validation rules, and serialization
- Ensure data integrity and consistency across your application

Whether you are building business-critical applications, APIs, or data processing pipelines, PHP Datatypes helps you write safer and more predictable PHP code.

### Key Benefits
- **Type Safety:** Eliminate runtime errors caused by unexpected data types
- **Precision:** Ensure accurate calculations with strict floating-point and integer handling
- **Range Safeguards:** Prevent overflows and underflows with explicit type boundaries
- **Readability:** Make your code self-documenting and easier to maintain
- **Performance:** Optimized for minimal runtime overhead
- **Extensibility:** Easily define your own types and validation rules

### Impact on Modern PHP Development
PHP Datatypes is designed to address the challenges of modern PHP development, where data integrity and type safety are paramount. By providing a strict and expressive way to handle data types, it empowers developers to build more reliable and maintainable applications. Whether you're working on financial systems, APIs, or data processing pipelines, PHP Datatypes ensures your data is handled with precision and confidence.

## Features
- **Strict Scalar Types:** Signed/unsigned integers (Int8, UInt8, etc.), floating points (Float32, Float64), booleans, chars, and bytes
- **Composite Types:** Structs, arrays, unions, lists, dictionaries, and more
- **Type-safe Operations:** Arithmetic, validation, and conversion with built-in safeguards
- **Serialization:** Easy conversion to/from array, JSON, and XML
- **Laravel Integration:** Ready for use in modern PHP frameworks
- **Extensible:** Easily define your own types and validation rules

## Installation

Install via Composer:

```bash
composer require nejcc/php-datatypes
```

## Why Use PHP Datatypes?
- **Type Safety:** Prevent invalid values and unexpected type coercion
- **Precision:** Control floating-point and integer precision for critical calculations
- **Range Safeguards:** Avoid overflows and underflows with explicit type boundaries
- **Readability:** Make your code self-documenting and easier to maintain

## Why Developers Love PHP Datatypes
- **Zero Runtime Overhead:** Optimized for performance with minimal overhead
- **Battle-Tested:** Used in production environments for critical applications
- **Community-Driven:** Actively maintained and supported by a growing community
- **Future-Proof:** Designed with modern PHP practices and future compatibility in mind
- **Must-Have for Enterprise:** Trusted by developers building scalable, secure, and maintainable applications

## Usage Examples

### Laravel Example
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;

class TestController
{
    public UInt8 $user_id;
    public Float32 $account_balance;

    public function __invoke(Request $request)
    {
        // Validating and assigning UInt8 (ensures non-negative user ID)
        $this->user_id = uint8($request->input('user_id'));
        // Validating and assigning Float32 (ensures correct precision)
        $this->account_balance = float32($request->input('account_balance'));
        // Now you can safely use the $user_id and $account_balance knowing they are in the right range
        dd([
            'user_id' => $this->user_id->getValue(),
            'account_balance' => $this->account_balance->getValue(),
        ]);
    }
}
```

### Scalar Types
#### Integers
```php
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;

$int8 = new Int8(-128); // Minimum value for Int8
echo $int8->getValue(); // -128

$uint8 = new UInt8(255); // Maximum value for UInt8
echo $uint8->getValue(); // 255
```

#### Floats
```php
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float64;

$float32 = new Float32(3.14);
echo $float32->getValue(); // 3.14

$float64 = new Float64(1.7976931348623157e308); // Maximum value for Float64
echo $float64->getValue(); // 1.7976931348623157e308
```

#### Arithmetic Operations
```php
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;

$int1 = new Int8(50);
$int2 = new Int8(30);

$result = $int1->add($int2); // Performs addition
echo $result->getValue(); // 80
```

## Roadmap

```md
Data Types
│
├── Scalar Types
│   ├── Integer Types
│   │   ├── Signed Integers
│   │   │   ├── ✓ Int8 
│   │   │   ├── ✓ Int16
│   │   │   ├── ✓ Int32
│   │   │   ├── Int64
│   │   │   └── Int128
│   │   └── Unsigned Integers
│   │       ├── ✓ UInt8
│   │       ├── ✓ UInt16
│   │       ├── ✓ UInt32
│   │       ├── UInt64
│   │       └── UInt128
│   ├── Floating Point Types
│   │   ├── ✓ Float32
│   │   ├── ✓ Float64
│   │   ├── Double
│   │   └── Double Floating Point
│   ├── Boolean
│   │   └── Boolean (true/false)
│   ├── Char
│   └── Byte
│
├── Composite Types
│   ├── Arrays
│   │   ├── StringArray
│   │   ├── IntArray
│   │   ├── FloatArray
│   │   └── Byte Slice
│   ├── Struct
│   │   └── struct { fields of different types }
│   ├── Union
│   │   └── union { shared memory for different types }
│   ├── List
│   └── Dictionary
│
├── Reference Types
│   ├── Reference Pointer
│   ├── Void (Nullable)
│   └── Channel (Concurrency)
│
├── Map Types
│   ├── Hashmap
│   └── Map
│
└── Specialized Types
    ├── String
    ├── Double
    ├── Slice
    ├── Map
    └── Channel
```

## Testing

Run the test suite with:
```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for details on recent changes.

## Contributing

Contributions are welcome! Please see [CONTRIBUTING](CONTRIBUTING.md) for guidelines.

## Security

If you discover any security-related issues, please email nejc.cotic@gmail.com instead of using the issue tracker.

## Credits
- [Nejc Cotic](https://github.com/nejcc)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Real-Life Examples

### Financial Application
In a financial application, precision and type safety are critical. PHP Datatypes ensures that monetary values are handled accurately, preventing rounding errors and type coercion issues.

```php
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float64;

$balance = new Float64(1000.50);
$interest = new Float64(0.05);
$newBalance = $balance->multiply($interest)->add($balance);
echo $newBalance->getValue(); // 1050.525
```

### API Development
When building APIs, data validation and type safety are essential. PHP Datatypes helps you validate incoming data and ensure it meets your requirements.

```php
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;

$userId = new UInt8($request->input('user_id'));
if ($userId->getValue() > 0) {
    // Process valid user ID
} else {
    // Handle invalid input
}
```

### Data Processing Pipeline
In data processing pipelines, ensuring data integrity is crucial. PHP Datatypes helps you maintain data consistency and prevent errors.

```php
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int32;

$data = [1, 2, 3, 4, 5];
$sum = new Int32(0);
foreach ($data as $value) {
    $sum = $sum->add(new Int32($value));
}
echo $sum->getValue(); // 15
```

## Advanced Usage

### Custom Types
PHP Datatypes allows you to define your own custom types, enabling you to encapsulate complex data structures and validation logic.

```php
use Nejcc\PhpDatatypes\Composite\Struct\Struct;

class UserProfile extends Struct
{
    public function __construct(array $data = [])
    {
        parent::__construct([
            'name' => ['type' => 'string', 'nullable' => false],
            'age' => ['type' => 'int', 'nullable' => false],
            'email' => ['type' => 'string', 'nullable' => true],
        ], $data);
    }
}

$profile = new UserProfile(['name' => 'Alice', 'age' => 30]);
echo $profile->get('name'); // Alice
```

### Validation Rules
You can define custom validation rules to ensure your data meets specific requirements.

```php
use Nejcc\PhpDatatypes\Composite\Struct\Struct;

$schema = [
    'email' => [
        'type' => 'string',
        'rules' => [fn($v) => filter_var($v, FILTER_VALIDATE_EMAIL)],
    ],
];

$struct = new Struct($schema, ['email' => 'invalid-email']);
// Throws ValidationException
```

### Serialization
PHP Datatypes supports easy serialization and deserialization of data structures.

```php
use Nejcc\PhpDatatypes\Composite\Struct\Struct;

$struct = new Struct([
    'id' => ['type' => 'int'],
    'name' => ['type' => 'string'],
], ['id' => 1, 'name' => 'Alice']);

$json = $struct->toJson();
echo $json; // {"id":1,"name":"Alice"}

$newStruct = Struct::fromJson($struct->getFields(), $json);
echo $newStruct->get('name'); // Alice
```
