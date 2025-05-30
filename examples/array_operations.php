<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;

/**
 * Example 1: Working with Arrays of Int8
 */
echo "Example 1: Working with Arrays of Int8\n";
echo "==================================\n";

try {
    // Create an array of Int8 values
    $numbers = [
        new Int8(10),
        new Int8(20),
        new Int8(30),
        new Int8(40),
        new Int8(50)
    ];

    // Sum all numbers
    $sum = new Int8(0);
    foreach ($numbers as $number) {
        $sum = $sum->add($number);
    }

    echo "Sum of numbers: " . $sum->getValue() . "\n";

    // Find maximum value
    $max = $numbers[0];
    foreach ($numbers as $number) {
        if ($number->greaterThan($max)) {
            $max = $number;
        }
    }

    echo "Maximum value: " . $max->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 2: Array Operations with Float32
 */
echo "\nExample 2: Array Operations with Float32\n";
echo "====================================\n";

try {
    // Create an array of Float32 values
    $temperatures = [
        new Float32(23.5),
        new Float32(24.8),
        new Float32(22.3),
        new Float32(25.1),
        new Float32(23.9)
    ];

    // Calculate average temperature
    $sum = new Float32(0.0);
    foreach ($temperatures as $temp) {
        $sum = $sum->add($temp);
    }
    $average = $sum->divide(new Float32(count($temperatures)));

    echo "Average temperature: " . $average->getValue() . "°C\n";

    // Find temperatures above average
    echo "Temperatures above average:\n";
    foreach ($temperatures as $temp) {
        if ($temp->greaterThan($average)) {
            echo "- " . $temp->getValue() . "°C\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 3: Mixed Type Arrays
 */
echo "\nExample 3: Mixed Type Arrays\n";
echo "=========================\n";

try {
    // Create arrays of different types
    $integers = [
        new Int8(1),
        new Int8(2),
        new Int8(3)
    ];

    $floats = [
        new Float32(1.5),
        new Float32(2.5),
        new Float32(3.5)
    ];

    // Convert integers to floats
    $convertedFloats = array_map(
        fn (Int8 $int) => new Float32($int->getValue()),
        $integers
    );

    echo "Original integers: " . implode(', ', array_map(fn (Int8 $int) => $int->getValue(), $integers)) . "\n";
    echo "Converted to floats: " . implode(', ', array_map(fn (Float32 $float) => $float->getValue(), $convertedFloats)) . "\n";

    // Add corresponding values
    $sums = [];
    for ($i = 0; $i < count($integers); $i++) {
        $sums[] = $floats[$i]->add(new Float32($integers[$i]->getValue()));
    }

    echo "Sums of corresponding values: " . implode(', ', array_map(fn (Float32 $float) => $float->getValue(), $sums)) . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 4: Array Filtering and Mapping
 */
echo "\nExample 4: Array Filtering and Mapping\n";
echo "==================================\n";

try {
    // Create an array of Int8 values
    $numbers = [
        new Int8(-5),
        new Int8(0),
        new Int8(5),
        new Int8(10),
        new Int8(15),
        new Int8(20)
    ];

    // Filter positive numbers
    $positiveNumbers = array_filter(
        $numbers,
        fn (Int8 $num) => $num->greaterThan(new Int8(0))
    );

    echo "Positive numbers: " . implode(', ', array_map(fn (Int8 $num) => $num->getValue(), $positiveNumbers)) . "\n";

    // Double each number
    $doubledNumbers = array_map(
        fn (Int8 $num) => $num->multiply(new Int8(2)),
        $numbers
    );

    echo "Doubled numbers: " . implode(', ', array_map(fn (Int8 $num) => $num->getValue(), $doubledNumbers)) . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 5: Array Reduction
 */
echo "\nExample 5: Array Reduction\n";
echo "========================\n";

try {
    // Create an array of Float32 values
    $values = [
        new Float32(1.5),
        new Float32(2.5),
        new Float32(3.5),
        new Float32(4.5)
    ];

    // Calculate product of all values
    $product = array_reduce(
        $values,
        fn (Float32 $carry, Float32 $item) => $carry->multiply($item),
        new Float32(1.0)
    );

    echo "Product of all values: " . $product->getValue() . "\n";

    // Calculate sum of squares
    $sumOfSquares = array_reduce(
        $values,
        fn (Float32 $carry, Float32 $item) => $carry->add($item->multiply($item)),
        new Float32(0.0)
    );

    echo "Sum of squares: " . $sumOfSquares->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
