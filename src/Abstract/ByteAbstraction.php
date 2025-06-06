<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Abstract;

/**
 * Abstract base for Byte-like types (8-bit unsigned integer).
 * Strict: throws OutOfRangeException if value is not 0-255.
 */
abstract class ByteAbstraction
{
    public const MIN_VALUE = 0;
    public const MAX_VALUE = 255;

    /**
     * @var int
     */
    protected int $value;

    /**
     * @param int $value
     *
     * @throws \OutOfRangeException
     */
    public function __construct(int $value)
    {
        if ($value < self::MIN_VALUE || $value > self::MAX_VALUE) {
            throw new \OutOfRangeException('Byte value must be between 0 and 255.');
        }
        $this->value = $value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }

    final public function getValue(): int
    {
        return $this->value;
    }

    final public function add(self|int $other): static
    {
        $otherValue = $other instanceof self ? $other->value : $other;
        return new static($this->wrap($this->value + $otherValue));
    }

    final public function subtract(self|int $other): static
    {
        $otherValue = $other instanceof self ? $other->value : $other;
        return new static($this->wrap($this->value - $otherValue));
    }

    final public function multiply(self|int $other): static
    {
        $otherValue = $other instanceof self ? $other->value : $other;
        return new static($this->wrap($this->value * $otherValue));
    }

    final public function divide(self|int $other): static
    {
        $otherValue = $other instanceof self ? $other->value : $other;
        if ($otherValue === 0) {
            throw new \DivisionByZeroError('Division by zero.');
        }
        return new static($this->wrap(intdiv($this->value, $otherValue)));
    }

    final public function and(self $other): static
    {
        return new static($this->value & $other->value);
    }

    final public function or(self $other): static
    {
        return new static($this->value | $other->value);
    }

    final public function xor(self $other): static
    {
        return new static($this->value ^ $other->value);
    }

    final public function not(): static
    {
        return new static(~$this->value & 0xFF);
    }

    final public function leftShift(int $positions): static
    {
        return new static(($this->value << $positions) & 0xFF);
    }

    final public function rightShift(int $positions): static
    {
        return new static($this->value >> $positions);
    }

    final public function shiftLeft(int $positions): static
    {
        return $this->leftShift($positions);
    }

    final public function shiftRight(int $positions): static
    {
        return $this->rightShift($positions);
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

    final public function toBinary(): string
    {
        return sprintf('%08b', $this->value);
    }

    final public function toHex(): string
    {
        return sprintf('%02X', $this->value);
    }

    final public static function fromBinary(string $binary): static
    {
        return new static(bindec($binary));
    }

    final public static function fromHex(string $hex): static
    {
        return new static(hexdec($hex));
    }

    /**
     * Wrap a value to 0-255 (used for arithmetic).
     *
     * @param int $value
     *
     * @return int
     */
    protected function wrap(int $value): int
    {
        return ($value + 256) % 256;
    }

    protected function setValue(float $value): void
    {
        // Disallow INF and -INF
        if (is_infinite($value)) {
            throw new OutOfRangeException('INF and -INF are not allowed for this float type.');
        }
        // ... existing range check ...
    }
}
