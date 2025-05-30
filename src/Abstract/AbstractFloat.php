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
     */
    public function __construct(float $value)
    {
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

    final public function add(self $other): static
    {
        return new static($this->value + $other->value);
    }

    final public function subtract(self $other): static
    {
        return new static($this->value - $other->value);
    }

    final public function multiply(self $other): static
    {
        return new static($this->value * $other->value);
    }

    final public function divide(self $other): static
    {
        if ($other->value === 0.0) {
            throw new \DivisionByZeroError('Division by zero.');
        }
        return new static($this->value / $other->value);
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
