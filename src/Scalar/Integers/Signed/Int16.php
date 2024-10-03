<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar\Integers\Signed;

use Nejcc\PhpDatatypes\Abstract\AbstractNativeInteger;

/**
 * Represents a 16-bit signed integer.
 *
 * @package Nejcc\PhpDatatypes\Integers\Signed
 */
final class Int16 extends AbstractNativeInteger
{
    /**
     * The minimum allowable value for Int16.
     *
     * @var int
     */
    public const MIN_VALUE = -32768;

    /**
     * The maximum allowable value for Int16.
     *
     * @var int
     */
    public const MAX_VALUE = 32767;

    // Inherit methods from AbstractInteger.
}
