<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar\Integers\Unsigned;

use Nejcc\PhpDatatypes\Abstract\AbstractBigInteger;

/**
 * Represents a 128-bit unsigned integer.
 *
 * This class provides a type-safe way to work with 128-bit unsigned integers,
 * ensuring values stay within the range of 0 to 2^128-1. It includes arithmetic
 * operations, comparisons, and range validation.
 *
 * @package Nejcc\PhpDatatypes\Integers\Unsigned
 *
 * @example
 * ```php
 * // Create a new UInt128 instance
 * $number = new UInt128('340282366920938463463374607431768211455');
 *
 * // Perform arithmetic operations
 * $sum = $number->add(new UInt128('1')); // Returns new UInt128('340282366920938463463374607431768211456')
 * $diff = $number->subtract(new UInt128('100')); // Returns new UInt128('340282366920938463463374607431768211355')
 *
 * // Compare values
 * $isGreater = $number->greaterThan(new UInt128('340282366920938463463374607431768211354')); // Returns true
 *
 * // Get the underlying value
 * $value = $number->getValue(); // Returns '340282366920938463463374607431768211455'
 * ```
 *
 * @throws \OutOfRangeException When the value is outside the valid range (0 to 2^128-1)
 * @throws \OverflowException When an arithmetic operation results in a value greater than MAX_VALUE
 * @throws \UnderflowException When an arithmetic operation results in a value less than 0
 * @throws \DivisionByZeroError When attempting to divide by zero
 * @throws \UnexpectedValueException When division results in a non-integer value
 */
final class UInt128 extends AbstractBigInteger
{
    /**
     * The minimum allowable value for UInt128 (0).
     *
     * @var string
     */
    public const MIN_VALUE = '0';

    /**
     * The maximum allowable value for UInt128 (2^128 - 1).
     *
     * @var string
     */
    public const MAX_VALUE = '340282366920938463463374607431768211455';

    // Inherit methods from AbstractBigInteger.
}
