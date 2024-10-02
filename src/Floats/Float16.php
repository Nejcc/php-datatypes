<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Floats;

use Nejcc\PhpDatatypes\Abstract\AbstractFloat;

/**
 * Represents a 16-bit float.
 *
 * @package Nejcc\PhpDatatypes\Floats
 */
final class Float16 extends AbstractFloat
{
    /**
     * The minimum allowable value for Float16.
     *
     * @var float
     */
    public const MIN_VALUE = -65504.0;

    /**
     * The maximum allowable value for Float16.
     *
     * @var float
     */
    public const MAX_VALUE = 65504.0;
}
