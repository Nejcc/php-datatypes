<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar\Integers\Signed;

use Nejcc\PhpDatatypes\Abstract\AbstractNativeInteger;

/**
 * Represents an 8-bit signed integer.
 *
 * This class provides a type-safe way to work with 8-bit signed integers,
 * ensuring values stay within the range of -128 to 127. It includes arithmetic
 * operations, comparisons, and range validation.
 *
 * @package Nejcc\PhpDatatypes\Integers\Signed
 *
 * @example
 * ```php
 * // Create a new Int8 instance
 * $number = new Int8(42);
 *
 * // Perform arithmetic operations
 * $sum = $number->add(new Int8(10)); // Returns new Int8(52)
 * $diff = $number->subtract(new Int8(5)); // Returns new Int8(37)
 *
 * // Compare values
 * $isGreater = $number->greaterThan(new Int8(40)); // Returns true
 *
 * // Get the underlying value
 * $value = $number->getValue(); // Returns 42
 * ```
 *
 * @throws \OutOfRangeException When the value is outside the valid range (-128 to 127)
 * @throws \OverflowException When an arithmetic operation results in a value greater than 127
 * @throws \UnderflowException When an arithmetic operation results in a value less than -128
 * @throws \DivisionByZeroError When attempting to divide by zero
 * @throws \UnexpectedValueException When division results in a non-integer value
 */
final class Int8 extends AbstractNativeInteger
{
    /**
     * The minimum allowable value for Int8 (-128).
     *
     * @var int
     */
    public const MIN_VALUE = -128;

    /**
     * The maximum allowable value for Int8 (127).
     *
     * @var int
     */
    public const MAX_VALUE = 127;

    public function __toString(): string
    {
        return (string)$this->getValue();
    }
}
