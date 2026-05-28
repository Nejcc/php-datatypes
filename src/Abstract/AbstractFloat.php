<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Abstract;

use OutOfRangeException;

abstract class AbstractFloat
{
    public const MIN_VALUE = null;
    public const MAX_VALUE = null;
    /**
     * @var float
     */
    protected readonly float $value;

    /**
     * @param float $value
     * @param bool $trusted Internal use only. When true, skips MIN/MAX and INF validation.
     *                     Used by arithmetic ops that already pre-check the result.
     */
    public function __construct(float $value, bool $trusted = false)
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
     * @return float
     */
    final public function getValue(): float
    {
        return $this->value;
    }

    #[\NoDiscard('add() returns a new immutable Float; the original is unchanged so discarding the result is always a bug')]
    final public function add(self $other): static
    {
        $result = $this->value + $other->value;
        if (is_infinite($result)) {
            throw new OutOfRangeException('INF and -INF are not allowed for this float type.');
        }
        if ($result > static::MAX_VALUE || $result < static::MIN_VALUE) {
            throw new OutOfRangeException(sprintf(
                'Value %f is out of range for this float type. Allowed range: [%f, %f]',
                $result,
                static::MIN_VALUE,
                static::MAX_VALUE
            ));
        }
        return new static($result, true);
    }

    #[\NoDiscard('subtract() returns a new immutable Float; the original is unchanged so discarding the result is always a bug')]
    final public function subtract(self $other): static
    {
        $result = $this->value - $other->value;
        if (is_infinite($result)) {
            throw new OutOfRangeException('INF and -INF are not allowed for this float type.');
        }
        if ($result > static::MAX_VALUE || $result < static::MIN_VALUE) {
            throw new OutOfRangeException(sprintf(
                'Value %f is out of range for this float type. Allowed range: [%f, %f]',
                $result,
                static::MIN_VALUE,
                static::MAX_VALUE
            ));
        }
        return new static($result, true);
    }

    #[\NoDiscard('multiply() returns a new immutable Float; the original is unchanged so discarding the result is always a bug')]
    final public function multiply(self $other): static
    {
        $result = $this->value * $other->value;
        if (is_infinite($result)) {
            throw new OutOfRangeException('INF and -INF are not allowed for this float type.');
        }
        if ($result > static::MAX_VALUE || $result < static::MIN_VALUE) {
            throw new OutOfRangeException(sprintf(
                'Value %f is out of range for this float type. Allowed range: [%f, %f]',
                $result,
                static::MIN_VALUE,
                static::MAX_VALUE
            ));
        }
        return new static($result, true);
    }

    #[\NoDiscard('divide() returns a new immutable Float; the original is unchanged so discarding the result is always a bug')]
    final public function divide(self $other): static
    {
        if ($other->value === 0.0) {
            throw new \DivisionByZeroError('Division by zero.');
        }
        $result = $this->value / $other->value;
        if (is_infinite($result)) {
            throw new OutOfRangeException('INF and -INF are not allowed for this float type.');
        }
        if ($result > static::MAX_VALUE || $result < static::MIN_VALUE) {
            throw new OutOfRangeException(sprintf(
                'Value %f is out of range for this float type. Allowed range: [%f, %f]',
                $result,
                static::MIN_VALUE,
                static::MAX_VALUE
            ));
        }
        return new static($result, true);
    }

    final public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    final public function isGreaterThan(self $other): bool
    {
        return $this->value > $other->value;
    }

    final public function isLessThan(self $other): bool
    {
        return $this->value < $other->value;
    }

    /**
     * @param float $value
     *
     * @return void
     */
    protected function setValue(float $value): void
    {
        // Disallow INF and -INF
        if (is_infinite($value)) {
            throw new OutOfRangeException('INF and -INF are not allowed for this float type.');
        }

        // Check if value is out of range
        if ($value > static::MAX_VALUE || $value < static::MIN_VALUE) {
            throw new OutOfRangeException(sprintf(
                'Value %f is out of range for this float type. Allowed range: [%f, %f]',
                $value,
                static::MIN_VALUE,
                static::MAX_VALUE
            ));
        }

        $this->value = $value;
    }
}
