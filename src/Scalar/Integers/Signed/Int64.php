<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar\Integers\Signed;

use Nejcc\PhpDatatypes\Abstract\AbstractBigInteger;

/**
 * Represents a 64-bit signed integer.
 *
 * This class provides a type-safe way to work with 64-bit signed integers,
 * ensuring values stay within the range of -9223372036854775808 to 9223372036854775807.
 * It includes arithmetic operations, comparisons, and range validation.
 *
 * @package Nejcc\PhpDatatypes\Integers\Signed
 *
 * @example
 * ```php
 * // Create a new Int64 instance
 * $number = new Int64('9223372036854775800');
 *
 * // Perform arithmetic operations
 * $sum = $number->add(new Int64('7')); // Returns new Int64('9223372036854775807')
 * $diff = $number->subtract(new Int64('100')); // Returns new Int64('9223372036854775700')
 *
 * // Compare values
 * $isGreater = $number->greaterThan(new Int64('9223372036854775700')); // Returns true
 *
 * // Get the underlying value
 * $value = $number->getValue(); // Returns '9223372036854775800'
 * ```
 *
 * @throws \OutOfRangeException When the value is outside the valid range
 * @throws \OverflowException When an arithmetic operation results in a value greater than MAX_VALUE
 * @throws \UnderflowException When an arithmetic operation results in a value less than MIN_VALUE
 * @throws \DivisionByZeroError When attempting to divide by zero
 * @throws \UnexpectedValueException When division results in a non-integer value
 */
final class Int64 extends AbstractBigInteger
{
    /**
     * The minimum allowable value for Int64 (-2^63).
     *
     * @var string
     */
    public const MIN_VALUE = '-9223372036854775808';

    /**
     * The maximum allowable value for Int64 (2^63 - 1).
     *
     * @var string
     */
    public const MAX_VALUE = '9223372036854775807';

    // Inherit methods from AbstractBigInteger.
}
