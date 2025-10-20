# Changelog

All notable changes to `php-datatypes` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2024-12-19

### Added
- PHP 8.4 compatibility and CI testing
- PHPStan static analysis configuration (level 9)
- `Dictionary::toArray()`, `isEmpty()`, and `getAll()` methods
- Benchmark suite for performance testing
- `Option<T>` type for nullable values
- `Result<T, E>` type for error handling
- Mutation testing with Infection
- Laravel integration (validation rules, service provider)
- PHPStorm metadata for better IDE support
- Comprehensive example demonstrating all features

### Changed
- **BREAKING:** All concrete datatype classes are now `final` to prevent inheritance issues
- **BREAKING:** All methods now have explicit return types for better type safety
- **BREAKING:** All Laravel validation rules and casts are now `final`
- Updated minimum PHP version requirement to ^8.4
- Enhanced CI workflow to test PHP 8.4
- Improved code quality with static analysis
- Enhanced parameter type declarations throughout the codebase

### Fixed
- Missing serialization methods in Dictionary class
- Missing return types in various methods
- Parameter type declarations for better type safety

### Migration Guide

If you were extending any datatype classes, you'll need to use composition instead:

**Before (v1.x):**
```php
class MyCustomInt8 extends Int8 {
    // custom implementation
}
```

**After (v2.0):**
```php
class MyCustomInt8 {
    private Int8 $int8;
    
    public function __construct(int $value) {
        $this->int8 = new Int8($value);
    }
    
    public function getValue(): int {
        return $this->int8->getValue();
    }
    
    // delegate other methods as needed
}
```

## [1.0.0] - 2024-12-19

### Added
- Initial release with comprehensive type system
- Scalar types: Int8, Int16, Int32, Int64, Int128, UInt8, UInt16, UInt32, UInt64, UInt128
- Floating point types: Float32, Float64
- Boolean, Char, and Byte types
- Composite types: Arrays, Structs, Unions, Lists, Dictionaries
- String types: AsciiString, Utf8String, EmailString, and 20+ specialized string types
- Vector types: Vec2, Vec3, Vec4
- Serialization support: JSON, XML, Binary
- Comprehensive test suite (592 tests, 1042 assertions)
- Helper functions for all types
- Type-safe operations with overflow/underflow protection
