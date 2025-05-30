# PHP Datatypes Examples

This directory contains example scripts demonstrating the usage of various data types provided by the PHP Datatypes library.

## Running the Examples

To run any example, use PHP from the command line:

```bash
php integer_operations.php
php float_operations.php
php array_operations.php
php char_operations.php
php boolean_operations.php
php string_operations.php
```

## Available Examples

### 1. Integer Operations (`integer_operations.php`)

This example demonstrates various operations with integer types:

- Basic arithmetic operations (addition, subtraction, multiplication, division)
- Range validation
- Overflow handling
- Comparison operations
- Working with different integer types (Int8, Int16, UInt8)
- Division and modulo operations

The example includes error handling to demonstrate how the library handles various edge cases and invalid operations.

### 2. Float Operations (`float_operations.php`)

This example demonstrates various operations with floating-point types:

- Basic arithmetic operations with Float32 and Float64
- Precision comparison between Float32 and Float64
- Handling of special values (Infinity, NaN, very small numbers)
- Comparison operations
- Rounding operations (round, ceil, floor)
- Mathematical functions (sin, cos, tan, sqrt)

The example includes error handling and demonstrates the precision differences between Float32 and Float64 types.

### 3. Array Operations (`array_operations.php`)

This example demonstrates working with arrays of typed values:

- Working with arrays of Int8 values (sum, max)
- Array operations with Float32 values (average, filtering)
- Mixed type arrays and type conversion
- Array filtering and mapping operations
- Array reduction operations (product, sum of squares)

The example shows how to use PHP's array functions with typed values while maintaining type safety.

### 4. Char Operations (`char_operations.php`)

This example demonstrates working with single characters:

- Basic character operations (creation, string conversion)
- Character type checking (letters, digits, case)
- ASCII operations (conversion to/from ASCII codes)
- Character comparison
- Error handling for invalid inputs
- Character transformation chains

The example shows how to work with individual characters in a type-safe way.

### 5. Boolean Operations (`boolean_operations.php`)

This example demonstrates working with boolean values:

- Basic boolean operations (creation, string conversion)
- Boolean logic operations (AND, OR, NOT)
- Boolean comparison
- Type conversion (from/to int, string, float)
- Error handling for invalid inputs
- Boolean chain operations

The example shows how to work with boolean values in a type-safe way.

### 6. String Operations (`string_operations.php`)

This example demonstrates working with strings:

- Basic string operations (creation, concatenation, length)
- String case operations (uppercase, lowercase, title case)
- String search and replace operations
- String trimming and padding
- String splitting and joining
- String comparison and validation
- String substring and character access
- String formatting with placeholders

The example shows how to work with strings in a type-safe way.

## Example Output

### Integer Operations Output

When you run `integer_operations.php`, you'll see output similar to this:

```
Example 1: Basic Int8 Operations
==============================
Number 1: 42
Number 2: 10
Sum: 52
Difference: 32
Product: 420
Quotient: 4

Example 2: Range Validation
========================
Range validation works: Value must be between -128 and 127.

Example 3: Overflow Handling
=========================
Overflow protection works: Result is out of bounds.

Example 4: Comparison Operations
=============================
Is 50 greater than 30? Yes
Is 50 less than 30? No
Is 50 equal to 30? No

Example 5: Working with Different Integer Types
===========================================
Int8 value: 100
Int16 value: 1000
UInt8 value: 200

Example 6: Division and Modulo Operations
=====================================
Division validation works: Division result is not an integer.
50 divided by 5 = 10
50 modulo 5 = 0
```

### Float Operations Output

When you run `float_operations.php`, you'll see output similar to this:

```
Example 1: Basic Float Operations
==============================
Float 1: 3.14159
Float 2: 2.0
Sum: 5.14159
Difference: 1.14159
Product: 6.28318
Quotient: 1.570795

Example 2: Precision Comparison
===========================
Float32 value: 1.2345678
Float64 value: 1.23456789
Note the difference in precision between Float32 and Float64

Example 3: Special Values
=====================
Infinity: INF
NaN: NAN
Very small number: 1.0E-45

Example 4: Comparison Operations
=============================
Is 3.14 greater than 2.71? Yes
Is 3.14 less than 2.71? No
Is 3.14 equal to 2.71? No

Example 5: Rounding Operations
==========================
Original number: 3.14159
Rounded to 2 decimal places: 3.14
Ceiling: 4
Floor: 3

Example 6: Mathematical Functions
=============================
Original number: 0.5
Sine: 0.4794255386042
Cosine: 0.87758256189037
Tangent: 0.54630248984379
Square root: 0.70710678118655
```

### Array Operations Output

When you run `array_operations.php`, you'll see output similar to this:

```
Example 1: Working with Arrays of Int8
==================================
Sum of numbers: 150
Maximum value: 50

Example 2: Array Operations with Float32
====================================
Average temperature: 23.92°C
Temperatures above average:
- 24.8°C
- 25.1°C

Example 3: Mixed Type Arrays
=========================
Original integers: 1, 2, 3
Converted to floats: 1.0, 2.0, 3.0
Sums of corresponding values: 2.5, 4.5, 6.5

Example 4: Array Filtering and Mapping
==================================
Positive numbers: 5, 10, 15, 20
Doubled numbers: -10, 0, 10, 20, 30, 40

Example 5: Array Reduction
========================
Product of all values: 59.0625
Sum of squares: 39.5
```

### Char Operations Output

When you run `char_operations.php`, you'll see output similar to this:

```
Example 1: Basic Char Operations
============================
Char 1: A
Char 2: b
Char 1 as string: A
Char 1 to lowercase: a
Char 2 to uppercase: B

Example 2: Character Type Checking
==============================
Is 'A' a letter? Yes
Is 'A' uppercase? Yes
Is 'A' lowercase? No

Is '5' a digit? Yes
Is '5' a letter? No

Is '@' a letter? No
Is '@' a digit? No

Example 3: ASCII Operations
========================
ASCII code of 'A': 65
Char from ASCII 65: A
ASCII 32 (space): ' '
ASCII 10 (newline): '
'

Example 4: Character Comparison
===========================
Is 'A' equal to 'A'? Yes
Is 'A' equal to 'B'? No
ASCII of 'A': 65
ASCII of 'B': 66

Example 5: Error Handling
======================
Error creating Char with multiple characters: Char must be a single character.
Error creating Char from invalid ASCII: ASCII value must be between 0 and 255.

Example 6: Character Transformation Chain
====================================
Original: a
To uppercase: A
Back to lowercase: a
ASCII code: 97
Back to char: a
```

### Boolean Operations Output

When you run `boolean_operations.php`, you'll see output similar to this:

```
Example 1: Basic Boolean Operations
==============================
True value: true
False value: false
True as string: true
False as string: false

Example 2: Boolean Logic Operations
================================
True AND True: true
True AND False: false
False AND False: false

True OR True: true
True OR False: true
False OR False: false

NOT True: false
NOT False: true

Example 3: Boolean Comparison
==========================
Is true equal to true? Yes
Is true equal to false? No
Is false equal to false? Yes

Example 4: Boolean Type Conversion
==============================
From integer 1: true
From string 'true': true
From float 1.0: true

To integer: 1
To string: true
To float: 1.0

Example 5: Error Handling
======================
Error creating Boolean from invalid string: Invalid boolean string value.
Error creating Boolean from invalid integer: Invalid boolean integer value.

Example 6: Boolean Chain Operations
================================
Chain 1 (true AND false OR true NOT): false
Chain 2 (false OR true AND true NOT): false
```

### String Operations Output

When you run `string_operations.php`, you'll see output similar to this:

```
Example 1: Basic String Operations
==============================
String 1: Hello
String 2: World
Concatenated: HelloWorld
Length of String 1: 5

Example 2: String Case Operations
==============================
Original: Hello World
Uppercase: HELLO WORLD
Lowercase: hello world
Title Case: Hello World

Example 3: String Search and Replace
================================
Contains 'World'? Yes
Starts with 'Hello'? Yes
Ends with 'PHP'? Yes
Replaced 'Hello' with 'Hi': Hi World, Hi PHP

Example 4: String Trimming and Padding
==================================
Original: '  Hello World  '
Trimmed: 'Hello World'
Left Trimmed: 'Hello World  '
Right Trimmed: '  Hello World'
Left Padded: '***Hello World'
Right Padded: 'Hello World***'

Example 5: String Splitting and Joining
===================================
Split by comma:
- Hello
- World
- PHP

Joined with space: Hello World PHP

Example 6: String Comparison and Validation
======================================
Is 'Hello' equal to 'Hello'? Yes
Is 'Hello' equal to 'World'? No

Is 'Hello123' alphanumeric? Yes
Is 'Hello123' alphabetic? No
Is '123' numeric? Yes

Example 7: String Substring and Character Access
==========================================
Original: Hello World
Substring(0, 5): Hello
Substring(6): World

Character at index 0: H
Character at index 6: W

Example 8: String Formatting
========================
Formatted: Hello, John! Welcome to PHP.
Formatted with names: Hello, John! Your age is 25.
```

## Understanding the Examples

Each example is designed to demonstrate specific features and behaviors of the library:

### Integer Examples
1. **Basic Operations**: Shows how to perform basic arithmetic with type-safe integers
2. **Range Validation**: Demonstrates how the library prevents values outside the valid range
3. **Overflow Handling**: Shows how the library prevents integer overflow
4. **Comparison Operations**: Demonstrates various comparison methods
5. **Different Types**: Shows how to work with different integer types
6. **Division Operations**: Demonstrates proper handling of division and modulo operations

### Float Examples
1. **Basic Operations**: Shows arithmetic operations with floating-point numbers
2. **Precision Comparison**: Demonstrates the difference between Float32 and Float64 precision
3. **Special Values**: Shows handling of special floating-point values
4. **Comparison Operations**: Demonstrates floating-point comparisons
5. **Rounding Operations**: Shows various rounding methods
6. **Mathematical Functions**: Demonstrates trigonometric and other mathematical functions

### Array Examples
1. **Int8 Arrays**: Shows working with arrays of Int8 values
2. **Float32 Arrays**: Demonstrates array operations with Float32 values
3. **Mixed Types**: Shows working with different types in arrays
4. **Filtering and Mapping**: Demonstrates array manipulation with typed values
5. **Reduction**: Shows how to use array reduction with typed values

### Char Examples
1. **Basic Operations**: Shows basic character operations and string conversion
2. **Type Checking**: Demonstrates character classification methods
3. **ASCII Operations**: Shows conversion between characters and ASCII codes
4. **Comparison**: Demonstrates character comparison methods
5. **Error Handling**: Shows handling of invalid inputs
6. **Transformation**: Demonstrates chaining of character transformations

### Boolean Examples
1. **Basic Operations**: Shows basic boolean operations and string conversion
2. **Logic Operations**: Demonstrates boolean logic operations (AND, OR, NOT)
3. **Comparison**: Shows boolean comparison methods
4. **Type Conversion**: Demonstrates conversion between boolean and other types
5. **Error Handling**: Shows handling of invalid inputs
6. **Chain Operations**: Demonstrates chaining of boolean operations

### String Examples
1. **Basic Operations**: Shows basic string operations and concatenation
2. **Case Operations**: Demonstrates string case manipulation methods
3. **Search and Replace**: Shows string search and replacement operations
4. **Trimming and Padding**: Demonstrates string trimming and padding methods
5. **Splitting and Joining**: Shows string splitting and joining operations
6. **Comparison and Validation**: Demonstrates string comparison and validation methods
7. **Substring and Character Access**: Shows substring and character access operations
8. **Formatting**: Demonstrates string formatting with placeholders

## Error Handling

The examples include proper error handling to demonstrate how the library handles various error conditions:

### Integer Errors
- `OutOfRangeException`: Thrown when a value is outside the valid range
- `OverflowException`: Thrown when an operation would result in a value too large
- `UnderflowException`: Thrown when an operation would result in a value too small
- `DivisionByZeroError`: Thrown when attempting to divide by zero
- `UnexpectedValueException`: Thrown when division results in a non-integer value

### Float Errors
- `OutOfRangeException`: Thrown when a value is outside the valid range
- `DivisionByZeroError`: Thrown when attempting to divide by zero
- `InvalidArgumentException`: Thrown when invalid arguments are provided to methods

### Array Errors
- `TypeError`: Thrown when array operations involve incompatible types
- `OutOfRangeException`: Thrown when array operations result in values outside valid ranges
- `OverflowException`: Thrown when array operations result in values too large
- `UnderflowException`: Thrown when array operations result in values too small

### Char Errors
- `InvalidArgumentException`: Thrown when creating a Char with multiple characters
- `InvalidArgumentException`: Thrown when creating a Char from invalid ASCII values

### Boolean Errors
- `InvalidArgumentException`: Thrown when creating a Boolean from invalid string
- `InvalidArgumentException`: Thrown when creating a Boolean from invalid integer
- `InvalidArgumentException`: Thrown when creating a Boolean from invalid float

### String Errors
- `InvalidArgumentException`: Thrown when creating a String with invalid input
- `OutOfRangeException`: Thrown when accessing invalid string indices
- `InvalidArgumentException`: Thrown when providing invalid arguments to string methods

## Contributing

Feel free to add more examples to demonstrate other features of the library. When adding new examples:

1. Create a new PHP file with a descriptive name
2. Include proper error handling
3. Add comments explaining the purpose of the example
4. Update this README to include information about your new example 