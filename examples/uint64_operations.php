<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt64;

// Example 1: Basic UInt64 Operations
echo "Example 1: Basic UInt64 Operations\n";
try {
    $number = new UInt64('18446744073709551610');
    echo "Created UInt64: " . $number->getValue() . "\n";

    // Addition
    $sum = $number->add(new UInt64('5'));
    echo "Addition: " . $sum->getValue() . "\n";

    // Subtraction
    $diff = $number->subtract(new UInt64('100'));
    echo "Subtraction: " . $diff->getValue() . "\n";

    // Multiplication
    $product = $number->multiply(new UInt64('2'));
    echo "Multiplication: " . $product->getValue() . "\n";

    // Division
    $quotient = $number->divide(new UInt64('2'));
    echo "Division: " . $quotient->getValue() . "\n";
} catch (Exception $e) {
    echo "Error in Example 1: " . $e->getMessage() . "\n";
}

// Example 2: Range Validation
echo "\nExample 2: Range Validation\n";
try {
    // Valid range
    $valid = new UInt64('18446744073709551615');
    echo "Valid maximum: " . $valid->getValue() . "\n";

    // Invalid range (should throw OutOfRangeException)
    $invalid = new UInt64('18446744073709551616');
    echo "This line should not be reached\n";
} catch (OutOfRangeException $e) {
    echo "Caught OutOfRangeException: " . $e->getMessage() . "\n";
}

// Example 3: Zero and Small Numbers
echo "\nExample 3: Zero and Small Numbers\n";
try {
    $zero = new UInt64('0');
    echo "Zero: " . $zero->getValue() . "\n";

    // Addition with zero
    $sum = $zero->add(new UInt64('100'));
    echo "Addition with zero: " . $sum->getValue() . "\n";

    // Subtraction from small number
    $small = new UInt64('100');
    $diff = $small->subtract(new UInt64('50'));
    echo "Subtraction from small number: " . $diff->getValue() . "\n";
} catch (Exception $e) {
    echo "Error in Example 3: " . $e->getMessage() . "\n";
}

// Example 4: Comparison Operations
echo "\nExample 4: Comparison Operations\n";
try {
    $a = new UInt64('18446744073709551610');
    $b = new UInt64('18446744073709551600');

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
    $max = new UInt64('18446744073709551615');
    echo "Maximum value: " . $max->getValue() . "\n";

    // This should cause an overflow
    $overflow = $max->add(new UInt64('1'));
    echo "This line should not be reached\n";
} catch (OverflowException $e) {
    echo "Caught OverflowException: " . $e->getMessage() . "\n";
}

try {
    $min = new UInt64('0');
    echo "Minimum value: " . $min->getValue() . "\n";

    // This should cause an underflow
    $underflow = $min->subtract(new UInt64('1'));
    echo "This line should not be reached\n";
} catch (UnderflowException $e) {
    echo "Caught UnderflowException: " . $e->getMessage() . "\n";
}
