<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar\Integers\Signed;

use Nejcc\PhpDatatypes\Abstract\AbstractNativeInteger;

/**
 * Represents a 32-bit signed integer.
 *
 * @package Nejcc\PhpDatatypes\Integers\Signed
 */
final class Int32 extends AbstractNativeInteger
{
    /**
     * The minimum allowable value for Int32.
     *
     * @var int
     */
    public const MIN_VALUE = -2147483648;

    /**
     * The maximum allowable value for Int32.
     *
     * @var int
     */
    public const MAX_VALUE = 2147483647;

    public function __toString(): string
    {
        return (string)$this->getValue();
    }
}
