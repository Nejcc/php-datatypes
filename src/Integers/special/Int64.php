<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Integers\special;

use Nejcc\PhpDatatypes\Abstract\AbstractBigInteger;

/**
 * Represents a 64-bit signed integer.
 *
 * @package Nejcc\PhpDatatypes\Integers\Signed
 */
final class Int64 extends AbstractBigInteger
{
    /**
     * The minimum allowable value for Int64.
     *
     * @var string
     */
    public const MIN_VALUE = '-9223372036854775808';

    /**
     * The maximum allowable value for Int64.
     *
     * @var string
     */
    public const MAX_VALUE = '9223372036854775807';

    // Inherit methods from AbstractInteger.
}
