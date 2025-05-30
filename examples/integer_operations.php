<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int16;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;

/**
 * Example 1: Basic Int8 Operations
 */
echo "Example 1: Basic Int8 Operations\n";
echo "==============================\n";

try {
    // Create Int8 instances
    $number1 = new Int8(42);
    $number2 = new Int8(10);
    
    // Arithmetic operations
    $sum = $number1->add($number2);
    $difference = $number1->subtract($number2);
    $product = $number1->multiply($number2);
    $quotient = $number1->divide($number2);
    
    echo "Number 1: " . $number1->getValue() . "\n";
    echo "Number 2: " . $number2->getValue() . "\n";
    echo "Sum: " . $sum->getValue() . "\n";
    echo "Difference: " . $difference->getValue() . "\n";
    echo "Product: " . $product->getValue() . "\n";
    echo "Quotient: " . $quotient->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 2: Range Validation
 */
echo "\nExample 2: Range Validation\n";
echo "========================\n";

try {
    // This will throw OutOfRangeException
    $invalidNumber = new Int8(200);
} catch (\OutOfRangeException $e) {
    echo "Range validation works: " . $e->getMessage() . "\n";
}

/**
 * Example 3: Overflow Handling
 */
echo "\nExample 3: Overflow Handling\n";
echo "=========================\n";

try {
    $maxInt8 = new Int8(Int8::MAX_VALUE);
    $overflow = $maxInt8->add(new Int8(1));
} catch (\OverflowException $e) {
    echo "Overflow protection works: " . $e->getMessage() . "\n";
}

/**
 * Example 4: Comparison Operations
 */
echo "\nExample 4: Comparison Operations\n";
echo "=============================\n";

$num1 = new Int8(50);
$num2 = new Int8(30);

echo "Is 50 greater than 30? " . ($num1->greaterThan($num2) ? "Yes" : "No") . "\n";
echo "Is 50 less than 30? " . ($num1->lessThan($num2) ? "Yes" : "No") . "\n";
echo "Is 50 equal to 30? " . ($num1->equals($num2) ? "Yes" : "No") . "\n";

/**
 * Example 5: Working with Different Integer Types
 */
echo "\nExample 5: Working with Different Integer Types\n";
echo "===========================================\n";

try {
    $int8 = new Int8(100);
    $int16 = new Int16(1000);
    $uint8 = new UInt8(200);
    
    echo "Int8 value: " . $int8->getValue() . "\n";
    echo "Int16 value: " . $int16->getValue() . "\n";
    echo "UInt8 value: " . $uint8->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 6: Division and Modulo Operations
 */
echo "\nExample 6: Division and Modulo Operations\n";
echo "=====================================\n";

try {
    $dividend = new Int8(50);
    $divisor = new Int8(3);
    
    // This will throw UnexpectedValueException because 50/3 is not an integer
    $result = $dividend->divide($divisor);
} catch (\UnexpectedValueException $e) {
    echo "Division validation works: " . $e->getMessage() . "\n";
}

try {
    $dividend = new Int8(50);
    $divisor = new Int8(5);
    
    $quotient = $dividend->divide($divisor);
    $remainder = $dividend->mod($divisor);
    
    echo "50 divided by 5 = " . $quotient->getValue() . "\n";
    echo "50 modulo 5 = " . $remainder->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 