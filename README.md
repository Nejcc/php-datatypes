# Introducing PHP Datatypes: A Strict and Safe Way to Handle Primitive Data Types

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nejcc/php-datatypes.svg?style=flat-square)](https://packagist.org/packages/nejcc/php-datatypes)
[![Total Downloads](https://img.shields.io/packagist/dt/nejcc/php-datatypes.svg?style=flat-square)](https://packagist.org/packages/nejcc/php-datatypes)
![GitHub Actions](https://github.com/nejcc/php-datatypes/actions/workflows/main.yml/badge.svg)


[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=bugs)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)

[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=coverage)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)

[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)


[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=Nejcc_php-datatypes&metric=ncloc)](https://sonarcloud.io/summary/new_code?id=Nejcc_php-datatypes)

I'm excited to share my latest PHP package, PHP Datatypes. This library introduces a flexible yet strict way of handling primitive data types like integers, floats, and strings in PHP. It emphasizes type safety and precision, supporting operations for signed and unsigned integers (Int8, UInt8, etc.) and various floating-point formats (Float32, Float64, etc.).

With PHP Datatypes, you get fine-grained control over the data you handle, ensuring your operations stay within valid ranges. It's perfect for anyone looking to avoid common pitfalls like overflows, division by zero, and unexpected type juggling in PHP.

## Installation

You can install the package via composer:

```bash
composer require nejcc/php-datatypes
```

## Usage

Below are examples of how to use the basic integer and float classes in your project.


This approach has a few key benefits:

- Type Safety: By explicitly defining the data types like UInt8, you're eliminating the risk of invalid values sneaking into your application. For example, enforcing unsigned integers ensures that the value remains within valid ranges, offering a safeguard against unexpected data inputs.


- Precision: Especially with floating-point numbers, handling precision can be tricky in PHP due to how it manages floats natively. By offering precise types such as Float32 or Float64, we're giving developers the control they need to maintain consistency in calculations.


- Range Safeguards: By specifying exact ranges, you can prevent issues like overflows or underflows that often go unchecked in dynamic typing languages like PHP.


- Readability and Maintenance: Explicit data types improve code readability. When a developer reads your code, they instantly know what type of value is expected and the constraints around that value. This enhances long-term maintainability.

### Laravel example

here's how it can be used in practice across different types, focusing on strict handling for both integers and floats:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;

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
Here, we're not only safeguarding user IDs but also handling potentially complex floating-point operations, where precision is critical. This could be especially beneficial for applications in fields like finance or analytics where data integrity is paramount.


PHP examples

### Integers

```php
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;

$int8 = new Int8(-128); // Minimum value for Int8
echo $int8->getValue(); // -128

$uint8 = new UInt8(255); // Maximum value for UInt8
echo $uint8->getValue(); // 255
```

### Floats

```php
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float64;

$float32 = new Float32(3.14);
echo $float32->getValue(); // 3.14

$float64 = new Float64(1.7976931348623157e308); // Maximum value for Float64
echo $float64->getValue(); // 1.7976931348623157e308
```

### Arithmetic Operations

```php
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;

$int1 = new Int8(50);
$int2 = new Int8(30);

$result = $int1->add($int2); // Performs addition
echo $result->getValue(); // 80

```

# ROAD MAP

```md
Data Types
│
├── Scalar Types
│   ├── Integer Types
│   │   ├── Signed Integers
│   │   │   ├── &check; Int8 
│   │   │   ├── &check; Int16
│   │   │   ├── &check; Int32
│   │   │   ├── Int64
│   │   │   └── Int128
│   │   └── Unsigned Integers
│   │       ├── &check; UInt8
│   │       ├── &check; UInt16
│   │       ├── &check; UInt32
│   │       ├── UInt64
│   │       └── UInt128
│   ├── Floating Point Types
│   │   ├── &check; Float32
│   │   ├── &check; Float64
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


### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email nejc.cotic@gmail.com instead of using the issue tracker.

## Credits
-   [Nejc Cotic](https://github.com/nejcc)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com) by [Beyond Code](http://beyondco.de/).
