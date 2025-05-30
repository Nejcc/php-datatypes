<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt128;

// Example 1: Basic UInt128 Operations
echo "Example 1: Basic UInt128 Operations\n";
try {
    $number = new UInt128('340282366920938463463374607431768211450');
    echo "Created UInt128: " . $number->getValue() . "\n";

    // Addition
    $sum = $number->add(new UInt128('5'));
    echo "Addition: " . $sum->getValue() . "\n";

    // Subtraction
    $diff = $number->subtract(new UInt128('100'));
    echo "Subtraction: " . $diff->getValue() . "\n";

    // Multiplication
    $product = $number->multiply(new UInt128('2'));
    echo "Multiplication: " . $product->getValue() . "\n";

    // Division
    $quotient = $number->divide(new UInt128('2'));
    echo "Division: " . $quotient->getValue() . "\n";
} catch (Exception $e) {
    echo "Error in Example 1: " . $e->getMessage() . "\n";
}

// Example 2: Range Validation
echo "\nExample 2: Range Validation\n";
try {
    // Valid range
    $valid = new UInt128('340282366920938463463374607431768211455');
    echo "Valid maximum: " . $valid->getValue() . "\n";

    // Invalid range (should throw OutOfRangeException)
    $invalid = new UInt128('340282366920938463463374607431768211456');
    echo "This line should not be reached\n";
} catch (OutOfRangeException $e) {
    echo "Caught OutOfRangeException: " . $e->getMessage() . "\n";
}

// Example 3: Zero and Small Numbers
echo "\nExample 3: Zero and Small Numbers\n";
try {
    $zero = new UInt128('0');
    echo "Zero: " . $zero->getValue() . "\n";

    // Addition with zero
    $sum = $zero->add(new UInt128('100'));
    echo "Addition with zero: " . $sum->getValue() . "\n";

    // Subtraction from small number
    $small = new UInt128('100');
    $diff = $small->subtract(new UInt128('50'));
    echo "Subtraction from small number: " . $diff->getValue() . "\n";
} catch (Exception $e) {
    echo "Error in Example 3: " . $e->getMessage() . "\n";
}

// Example 4: Comparison Operations
echo "\nExample 4: Comparison Operations\n";
try {
    $a = new UInt128('340282366920938463463374607431768211450');
    $b = new UInt128('340282366920938463463374607431768211400');

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
    $max = new UInt128('340282366920938463463374607431768211455');
    echo "Maximum value: " . $max->getValue() . "\n";

    // This should cause an overflow
    $overflow = $max->add(new UInt128('1'));
    echo "This line should not be reached\n";
} catch (OverflowException $e) {
    echo "Caught OverflowException: " . $e->getMessage() . "\n";
}

try {
    $min = new UInt128('0');
    echo "Minimum value: " . $min->getValue() . "\n";

    // This should cause an underflow
    $underflow = $min->subtract(new UInt128('1'));
    echo "This line should not be reached\n";
} catch (UnderflowException $e) {
    echo "Caught UnderflowException: " . $e->getMessage() . "\n";
}
