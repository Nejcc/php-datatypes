<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float64;

/**
 * Example 1: Basic Float Operations
 */
echo "Example 1: Basic Float Operations\n";
echo "==============================\n";

try {
    // Create Float32 instances
    $float1 = new Float32(3.14159);
    $float2 = new Float32(2.0);

    // Arithmetic operations
    $sum = $float1->add($float2);
    $difference = $float1->subtract($float2);
    $product = $float1->multiply($float2);
    $quotient = $float1->divide($float2);

    echo "Float 1: " . $float1->getValue() . "\n";
    echo "Float 2: " . $float2->getValue() . "\n";
    echo "Sum: " . $sum->getValue() . "\n";
    echo "Difference: " . $difference->getValue() . "\n";
    echo "Product: " . $product->getValue() . "\n";
    echo "Quotient: " . $quotient->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 2: Precision Comparison
 */
echo "\nExample 2: Precision Comparison\n";
echo "===========================\n";

try {
    $float32 = new Float32(1.23456789);
    $float64 = new Float64(1.23456789);

    echo "Float32 value: " . $float32->getValue() . "\n";
    echo "Float64 value: " . $float64->getValue() . "\n";
    echo "Note the difference in precision between Float32 and Float64\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 3: Special Values
 */
echo "\nExample 3: Special Values\n";
echo "=====================\n";

try {
    // Infinity
    $infinity = new Float64(INF);
    echo "Infinity: " . $infinity->getValue() . "\n";

    // NaN
    $nan = new Float64(NAN);
    echo "NaN: " . $nan->getValue() . "\n";

    // Very small number
    $small = new Float64(1.0E-45);
    echo "Very small number: " . $small->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 4: Comparison Operations
 */
echo "\nExample 4: Comparison Operations\n";
echo "=============================\n";

try {
    $num1 = new Float32(3.14);
    $num2 = new Float32(2.71);

    echo "Is 3.14 greater than 2.71? " . ($num1->greaterThan($num2) ? "Yes" : "No") . "\n";
    echo "Is 3.14 less than 2.71? " . ($num1->lessThan($num2) ? "Yes" : "No") . "\n";
    echo "Is 3.14 equal to 2.71? " . ($num1->equals($num2) ? "Yes" : "No") . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 5: Rounding Operations
 */
echo "\nExample 5: Rounding Operations\n";
echo "==========================\n";

try {
    $number = new Float32(3.14159);

    echo "Original number: " . $number->getValue() . "\n";
    echo "Rounded to 2 decimal places: " . $number->round(2)->getValue() . "\n";
    echo "Ceiling: " . $number->ceil()->getValue() . "\n";
    echo "Floor: " . $number->floor()->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 6: Mathematical Functions
 */
echo "\nExample 6: Mathematical Functions\n";
echo "=============================\n";

try {
    $number = new Float32(0.5);

    echo "Original number: " . $number->getValue() . "\n";
    echo "Sine: " . $number->sin()->getValue() . "\n";
    echo "Cosine: " . $number->cos()->getValue() . "\n";
    echo "Tangent: " . $number->tan()->getValue() . "\n";
    echo "Square root: " . $number->sqrt()->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
