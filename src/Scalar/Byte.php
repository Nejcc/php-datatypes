<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar;

use Nejcc\PhpDatatypes\Abstract\ByteAbstraction;

/**
 * Concrete Byte type (8-bit unsigned integer, 0-255).
 * Inherits all logic from ByteAbstraction.
 */
final class Byte extends ByteAbstraction
{
    /**
     * Flyweight cache of all 256 valid Byte values. Lazily populated.
     *
     * @var array<int, self>
     */
    private static array $cache = [];

    /**
     * Return a cached Byte instance for the given value.
     *
     * The Byte domain is exactly 256 values (0-255) and instances are
     * immutable, so sharing is safe.
     */
    public static function of(int $value): self
    {
        return self::$cache[$value] ??= new self($value);
    }
}
