<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Abstract;

use Nejcc\PhpDatatypes\Interfaces\BigIntegerInterface;
use Nejcc\PhpDatatypes\Interfaces\NativeIntegerInterface;
use Nejcc\PhpDatatypes\Traits\BigArithmeticOperationsTrait;
use Nejcc\PhpDatatypes\Traits\BigIntegerComparisonTrait;

/**
 * Abstract class for big integer types using arbitrary-precision arithmetic.
 *
 * @package Nejcc\PhpDatatypes\Integers
 */
abstract class AbstractBigInteger implements BigIntegerInterface
{
    use BigArithmeticOperationsTrait;
    use BigIntegerComparisonTrait;

    public const MIN_VALUE = null;
    public const MAX_VALUE = null;

    /**
     * @var string
     */
    protected readonly string $value;

    /**
     * @param int|string $value
     * @param bool $trusted Internal use only. When true, skips MIN/MAX validation.
     *                     Used by arithmetic ops that already pre-check the result.
     */
    public function __construct(int|string $value, bool $trusted = false)
    {
        if ($trusted) {
            $this->value = (string)$value;
            return;
        }
        $this->setValue($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param NativeIntegerInterface|BigIntegerInterface $other
     *
     * @return int
     */
    final public function compare(NativeIntegerInterface|BigIntegerInterface $other): int
    {
        return bccomp($this->value, (string)$other->getValue());
    }

    /**
     * @param int|string $value
     *
     * @return void
     */
    protected function setValue(int|string $value): void
    {
        $valueStr = (string)$value;

        if (bccomp($valueStr, (string)static::MIN_VALUE) < 0 || bccomp($valueStr, (string)static::MAX_VALUE) > 0) {
            throw new \OutOfRangeException(sprintf(
                'Value must be between %s and %s.',
                static::MIN_VALUE,
                static::MAX_VALUE
            ));
        }

        $this->value = $valueStr;
    }
}
