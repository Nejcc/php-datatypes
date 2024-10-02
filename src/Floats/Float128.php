<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Floats;

use Nejcc\PhpDatatypes\Abstract\AbstractFloat;

/**
 * Represents a 128-bit float.
 *
 * @package Nejcc\PhpDatatypes\Floats
 */
final class Float128 extends AbstractFloat
{
    /**
     * The minimum allowable value for Float128.
     *
     * @var float
     */
    public const MIN_VALUE = -1.18973149535723176508575932662800702e4932;

    /**
     * The maximum allowable value for Float128.
     *
     * @var float
     */
    public const MAX_VALUE = 1.18973149535723176508575932662800702e4932;
}
