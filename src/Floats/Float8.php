<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Floats;

use Nejcc\PhpDatatypes\Abstract\AbstractFloat;

/**
 * Represents an 8-bit float.
 *
 * @package Nejcc\PhpDatatypes\Floats
 */
final class Float8 extends AbstractFloat
{
    /**
     * The minimum allowable value for Float8.
     *
     * @var float
     */
    public const MIN_VALUE = -240.0;

    /**
     * The maximum allowable value for Float8.
     *
     * @var float
     */
    public const MAX_VALUE = 240.0;
}
