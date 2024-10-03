<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar\Integers\Unsigned;

use Nejcc\PhpDatatypes\Abstract\AbstractNativeInteger;

/**
 * Represents a 32-bit unsigned integer.
 *
 * @package Nejcc\PhpDatatypes\Integers\Unsigned
 */
final class UInt32 extends AbstractNativeInteger
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '4294967295';
}
