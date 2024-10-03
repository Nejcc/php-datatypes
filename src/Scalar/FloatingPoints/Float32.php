<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar\FloatingPoints;

use Nejcc\PhpDatatypes\Abstract\AbstractFloat;

/**
 * Represents a 32-bit float.
 *
 * @package Nejcc\PhpDatatypes\Floats
 */
final class Float32 extends AbstractFloat
{
    /**
     * The minimum allowable value for Float32.
     *
     * @var float
     */
    public const MIN_VALUE = -3.4028235e38;

    /**
     * The maximum allowable value for Float32.
     *
     * @var float
     */
    public const MAX_VALUE = 3.4028235e38;
}
