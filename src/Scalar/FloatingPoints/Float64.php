<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar\FloatingPoints;

use Nejcc\PhpDatatypes\Abstract\AbstractFloat;

/**
 * Represents a 64-bit float.
 *
 * @package Nejcc\PhpDatatypes\Floats
 */
final class Float64 extends AbstractFloat
{
    /**
     * The minimum allowable value for Float64.
     *
     * @var float
     */
    public const MIN_VALUE = -1.7976931348623157e308;

    /**
     * The maximum allowable value for Float64.
     *
     * @var float
     */
    public const MAX_VALUE = 1.7976931348623157e308;
}
