<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Integers\Unsigned;

use Nejcc\PhpDatatypes\Abstract\AbstractNativeInteger;

/**
 * Represents a 16-bit unsigned integer.
 *
 * @package Nejcc\PhpDatatypes\Integers\Unsigned
 */
final class UInt16 extends AbstractNativeInteger
{
    public const MIN_VALUE = 0;
    public const MAX_VALUE = 65535;
}
