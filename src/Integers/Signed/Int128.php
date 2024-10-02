<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Integers\Signed;

use Nejcc\PhpDatatypes\Abstract\AbstractBigInteger;

/**
 * Represents a 128-bit signed integer.
 *
 * @package Nejcc\PhpDatatypes\Integers\Signed
 */
final class Int128 extends AbstractBigInteger
{
    /**
     * The minimum allowable value for Int128.
     *
     * @var string
     */
    public const MIN_VALUE = '-170141183460469231731687303715884105728';

    /**
     * The maximum allowable value for Int128.
     *
     * @var string
     */
    public const MAX_VALUE = '170141183460469231731687303715884105727';

    // Inherit methods from AbstractInteger.
}
