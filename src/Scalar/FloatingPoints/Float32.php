<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar\FloatingPoints;

use Nejcc\PhpDatatypes\Abstract\AbstractFloat;

/**
 * Represents a 32-bit floating-point number (single precision).
 *
 * This class provides a type-safe way to work with 32-bit floating-point numbers,
 * ensuring values stay within the valid range and maintaining proper precision.
 * It includes arithmetic operations, comparisons, and mathematical functions.
 *
 * @package Nejcc\PhpDatatypes\Scalar\FloatingPoints
 *
 * @example
 * ```php
 * // Create a new Float32 instance
 * $number = new Float32(3.14159);
 *
 * // Perform arithmetic operations
 * $sum = $number->add(new Float32(2.0)); // Returns new Float32(5.14159)
 * $product = $number->multiply(new Float32(2.0)); // Returns new Float32(6.28318)
 *
 * // Use mathematical functions
 * $sine = $number->sin(); // Returns sine of the number
 * $sqrt = $number->sqrt(); // Returns square root of the number
 *
 * // Rounding operations
 * $rounded = $number->round(2); // Returns new Float32(3.14)
 * ```
 *
 * @property-read float $value The underlying float value
 *
 * @method Float32 add(Float32 $other) Adds two Float32 numbers
 * @method Float32 subtract(Float32 $other) Subtracts two Float32 numbers
 * @method Float32 multiply(Float32 $other) Multiplies two Float32 numbers
 * @method Float32 divide(Float32 $other) Divides two Float32 numbers
 * @method Float32 round(int $precision = 0) Rounds the number to specified precision
 * @method Float32 ceil() Rounds the number up to the nearest integer
 * @method Float32 floor() Rounds the number down to the nearest integer
 * @method Float32 sin() Returns the sine of the number
 * @method Float32 cos() Returns the cosine of the number
 * @method Float32 tan() Returns the tangent of the number
 * @method Float32 sqrt() Returns the square root of the number
 *
 * @throws \OutOfRangeException When the value is outside the valid range
 * @throws \DivisionByZeroError When attempting to divide by zero
 * @throws \InvalidArgumentException When invalid arguments are provided to methods
 */
final class Float32 extends AbstractFloat
{
    /**
     * The minimum allowable value for Float32 (-3.4028235E+38).
     *
     * @var float
     */
    public const MIN_VALUE = -3.4028235E+38;

    /**
     * The maximum allowable value for Float32 (3.4028235E+38).
     *
     * @var float
     */
    public const MAX_VALUE = 3.4028235E+38;

    /**
     * The smallest positive value for Float32 (1.17549435E-38).
     *
     * @var float
     */
    public const MIN_POSITIVE_VALUE = 1.17549435E-38;

    /**
     * The precision of Float32 (approximately 7 decimal digits).
     *
     * @var int
     */
    public const PRECISION = 7;
}
