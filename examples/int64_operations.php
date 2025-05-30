<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int64;

// Example 1: Basic Int64 Operations
echo "Example 1: Basic Int64 Operations\n";
try {
    $number = new Int64('9223372036854775800');
    echo "Created Int64: " . $number->getValue() . "\n";
    
    // Addition
    $sum = $number->add(new Int64('7'));
    echo "Addition: " . $sum->getValue() . "\n";
    
    // Subtraction
    $diff = $number->subtract(new Int64('100'));
    echo "Subtraction: " . $diff->getValue() . "\n";
    
    // Multiplication
    $product = $number->multiply(new Int64('2'));
    echo "Multiplication: " . $product->getValue() . "\n";
    
    // Division
    $quotient = $number->divide(new Int64('2'));
    echo "Division: " . $quotient->getValue() . "\n";
} catch (Exception $e) {
    echo "Error in Example 1: " . $e->getMessage() . "\n";
}

// Example 2: Range Validation
echo "\nExample 2: Range Validation\n";
try {
    // Valid range
    $valid = new Int64('9223372036854775807');
    echo "Valid maximum: " . $valid->getValue() . "\n";
    
    // Invalid range (should throw OutOfRangeException)
    $invalid = new Int64('9223372036854775808');
    echo "This line should not be reached\n";
} catch (OutOfRangeException $e) {
    echo "Caught OutOfRangeException: " . $e->getMessage() . "\n";
}

// Example 3: Arithmetic Operations with Negative Numbers
echo "\nExample 3: Arithmetic with Negative Numbers\n";
try {
    $negative = new Int64('-9223372036854775800');
    echo "Negative number: " . $negative->getValue() . "\n";
    
    // Addition with negative
    $sum = $negative->add(new Int64('100'));
    echo "Addition with negative: " . $sum->getValue() . "\n";
    
    // Subtraction with negative
    $diff = $negative->subtract(new Int64('100'));
    echo "Subtraction with negative: " . $diff->getValue() . "\n";
} catch (Exception $e) {
    echo "Error in Example 3: " . $e->getMessage() . "\n";
}

// Example 4: Comparison Operations
echo "\nExample 4: Comparison Operations\n";
try {
    $a = new Int64('9223372036854775800');
    $b = new Int64('9223372036854775700');
    
    echo "A: " . $a->getValue() . "\n";
    echo "B: " . $b->getValue() . "\n";
    
    echo "A > B: " . ($a->greaterThan($b) ? 'true' : 'false') . "\n";
    echo "A < B: " . ($a->lessThan($b) ? 'true' : 'false') . "\n";
    echo "A == B: " . ($a->equals($b) ? 'true' : 'false') . "\n";
} catch (Exception $e) {
    echo "Error in Example 4: " . $e->getMessage() . "\n";
}

// Example 5: Overflow/Underflow Handling
echo "\nExample 5: Overflow/Underflow Handling\n";
try {
    $max = new Int64('9223372036854775807');
    echo "Maximum value: " . $max->getValue() . "\n";
    
    // This should cause an overflow
    $overflow = $max->add(new Int64('1'));
    echo "This line should not be reached\n";
} catch (OverflowException $e) {
    echo "Caught OverflowException: " . $e->getMessage() . "\n";
}

try {
    $min = new Int64('-9223372036854775808');
    echo "Minimum value: " . $min->getValue() . "\n";
    
    // This should cause an underflow
    $underflow = $min->subtract(new Int64('1'));
    echo "This line should not be reached\n";
} catch (UnderflowException $e) {
    echo "Caught UnderflowException: " . $e->getMessage() . "\n";
} 