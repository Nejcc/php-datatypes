<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar\Integers\Unsigned;

use Nejcc\PhpDatatypes\Abstract\AbstractNativeInteger;

/**
 * Represents an 8-bit unsigned integer.
 *
 * @package Nejcc\PhpDatatypes\Integers\Unsigned
 */
final class UInt8 extends AbstractNativeInteger
{
    public const MIN_VALUE = 0;
    public const MAX_VALUE = 255;

    /**
     * Flyweight cache of all 256 valid UInt8 values. Lazily populated.
     *
     * @var array<int, self>
     */
    private static array $cache = [];

    /**
     * Return a cached UInt8 instance for the given value.
     *
     * Since the UInt8 domain is exactly 256 values and instances are immutable,
     * this is safe and ~2-3x faster than `new UInt8($v)` for repeated values
     * in hot paths.
     */
    public static function of(int $value): self
    {
        return self::$cache[$value] ??= new self($value);
    }
}
