<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Abstract;

use Nejcc\PhpDatatypes\Attributes\Range;
use Nejcc\PhpDatatypes\Interfaces\NativeIntegerInterface;
use Nejcc\PhpDatatypes\Traits\NativeArithmeticOperationsTrait;
use Nejcc\PhpDatatypes\Traits\NativeIntegerComparisonTrait;

/**
 * Abstract class for native integer types.
 *
 * @package Nejcc\PhpDatatypes\Integers
 */
abstract class AbstractNativeInteger implements NativeIntegerInterface
{
    use NativeArithmeticOperationsTrait;
    use NativeIntegerComparisonTrait;

    public const MIN_VALUE = null;
    public const MAX_VALUE = null;

    protected readonly int $value;

    /**
     * @param int $value
     * @param bool $trusted Internal use only. When true, skips MIN/MAX validation.
     *                     Callers must guarantee the value is already within range
     *                     (used by arithmetic ops that pre-check the result).
     */
    public function __construct(int $value, bool $trusted = false)
    {
        if ($trusted) {
            $this->value = $value;
            return;
        }
        $this->setValue($value);
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }

    /**
     * @return int
     */
    final public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param NativeIntegerInterface $other
     *
     * @return int
     */
    final public function compare(NativeIntegerInterface $other): int
    {
        return $this->value <=> $other->getValue();
    }

    /**
     * @param int $value
     *
     * @return void
     */
    protected function setValue(int $value): void
    {
        if ($value < static::MIN_VALUE || $value > static::MAX_VALUE) {
            throw new \OutOfRangeException(sprintf(
                'Value must be between %d and %d.',
                static::MIN_VALUE,
                static::MAX_VALUE
            ));
        }

        $this->value = $value;
    }
}
