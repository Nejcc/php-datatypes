<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Integers\Signed;

use Nejcc\PhpDatatypes\Abstract\AbstractNativeInteger;

/**
 * Represents an 8-bit signed integer.
 *
 * @package Nejcc\PhpDatatypes\Integers\Signed
 */
final class Int8 extends AbstractNativeInteger
{
    /**
     * The minimum allowable value for Int8.
     *
     * @var int
     */
    public const MIN_VALUE = -128;

    /**
     * The maximum allowable value for Int8.
     *
     * @var int
     */
    public const MAX_VALUE = 127;
}
