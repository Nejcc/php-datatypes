<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar\Integers\Unsigned;

use Nejcc\PhpDatatypes\Abstract\AbstractBigInteger;

/**
 * Represents a 64-bit unsigned integer.
 *
 * This class provides a type-safe way to work with 64-bit unsigned integers,
 * ensuring values stay within the range of 0 to 2^64-1. It includes arithmetic
 * operations, comparisons, and range validation.
 *
 * @package Nejcc\PhpDatatypes\Integers\Unsigned
 *
 * @example
 * ```php
 * // Create a new UInt64 instance
 * $number = new UInt64('18446744073709551615');
 *
 * // Perform arithmetic operations
 * $sum = $number->add(new UInt64('1')); // Returns new UInt64('18446744073709551616')
 * $diff = $number->subtract(new UInt64('100')); // Returns new UInt64('18446744073709551515')
 *
 * // Compare values
 * $isGreater = $number->greaterThan(new UInt64('18446744073709551515')); // Returns true
 *
 * // Get the underlying value
 * $value = $number->getValue(); // Returns '18446744073709551615'
 * ```
 *
 * @throws \OutOfRangeException When the value is outside the valid range (0 to 2^64-1)
 * @throws \OverflowException When an arithmetic operation results in a value greater than MAX_VALUE
 * @throws \UnderflowException When an arithmetic operation results in a value less than 0
 * @throws \DivisionByZeroError When attempting to divide by zero
 * @throws \UnexpectedValueException When division results in a non-integer value
 */
final class UInt64 extends AbstractBigInteger
{
    /**
     * The minimum allowable value for UInt64 (0).
     *
     * @var string
     */
    public const MIN_VALUE = '0';

    /**
     * The maximum allowable value for UInt64 (2^64 - 1).
     *
     * @var string
     */
    public const MAX_VALUE = '18446744073709551615';



    // Inherit methods from AbstractBigInteger.
}
