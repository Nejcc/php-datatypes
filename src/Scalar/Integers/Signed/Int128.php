<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar\Integers\Signed;

use Nejcc\PhpDatatypes\Abstract\AbstractBigInteger;

/**
 * Represents a 128-bit signed integer.
 *
 * This class provides a type-safe way to work with 128-bit signed integers,
 * ensuring values stay within the range of -2^127 to 2^127-1. It includes arithmetic
 * operations, comparisons, and range validation.
 *
 * @package Nejcc\PhpDatatypes\Integers\Signed
 *
 * @example
 * ```php
 * // Create a new Int128 instance
 * $number = new Int128('170141183460469231731687303715884105727');
 *
 * // Perform arithmetic operations
 * $sum = $number->add(new Int128('1')); // Returns new Int128('170141183460469231731687303715884105728')
 * $diff = $number->subtract(new Int128('100')); // Returns new Int128('170141183460469231731687303715884105627')
 *
 * // Compare values
 * $isGreater = $number->greaterThan(new Int128('170141183460469231731687303715884105626')); // Returns true
 *
 * // Get the underlying value
 * $value = $number->getValue(); // Returns '170141183460469231731687303715884105727'
 * ```
 *
 * @throws \OutOfRangeException When the value is outside the valid range
 * @throws \OverflowException When an arithmetic operation results in a value greater than MAX_VALUE
 * @throws \UnderflowException When an arithmetic operation results in a value less than MIN_VALUE
 * @throws \DivisionByZeroError When attempting to divide by zero
 * @throws \UnexpectedValueException When division results in a non-integer value
 */
final class Int128 extends AbstractBigInteger
{
    /**
     * The minimum allowable value for Int128 (-2^127).
     *
     * @var string
     */
    public const MIN_VALUE = '-170141183460469231731687303715884105728';

    /**
     * The maximum allowable value for Int128 (2^127 - 1).
     *
     * @var string
     */
    public const MAX_VALUE = '170141183460469231731687303715884105727';

    // Inherit methods from AbstractBigInteger.
}
