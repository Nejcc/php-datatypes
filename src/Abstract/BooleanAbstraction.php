<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Abstract;

/**
 * Abstract base for Boolean-like types.
 * Provides common boolean operations and conversions.
 */
abstract class BooleanAbstraction
{
    /**
     * @var bool
     */
    protected bool $value;

    /**
     * @param bool $value
     */
    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    /**
     * Converts the Boolean to a string representation.
     *
     * @return string "true" or "false"
     */
    public function __toString(): string
    {
        return $this->value ? 'true' : 'false';
    }

    /**
     * Gets the underlying boolean value.
     *
     * @return bool The boolean value
     */
    final public function getValue(): bool
    {
        return $this->value;
    }

    /**
     * Performs a logical AND operation with another Boolean.
     *
     * @param self $other The other Boolean to AND with
     *
     * @return static A new instance with the result
     */
    final public function and(self $other): static
    {
        return new static($this->value && $other->getValue());
    }

    /**
     * Performs a logical OR operation with another Boolean.
     *
     * @param self $other The other Boolean to OR with
     *
     * @return static A new instance with the result
     */
    final public function or(self $other): static
    {
        return new static($this->value || $other->getValue());
    }

    /**
     * Performs a logical XOR operation with another Boolean.
     *
     * @param self $other The other Boolean to XOR with
     *
     * @return static A new instance with the result
     */
    final public function xor(self $other): static
    {
        return new static($this->value xor $other->getValue());
    }

    /**
     * Performs a logical NOT operation.
     *
     * @return static A new instance with the negated value
     */
    final public function not(): static
    {
        return new static(!$this->value);
    }

    /**
     * Checks if this Boolean equals another Boolean.
     *
     * @param self $other The other Boolean to compare with
     *
     * @return bool True if the values are equal, false otherwise
     */
    final public function equals(self $other): bool
    {
        return $this->value === $other->getValue();
    }

    /**
     * Creates a Boolean instance from a string.
     *
     * @param string $value The string to convert ("true", "false", "1", "0")
     *
     * @return static A new instance
     *
     * @throws \InvalidArgumentException If the string is not a valid boolean representation
     */
    final public static function fromString(string $value): static
    {
        $value = strtolower($value);
        if ($value === 'true' || $value === '1') {
            return new static(true);
        }
        if ($value === 'false' || $value === '0') {
            return new static(false);
        }
        throw new \InvalidArgumentException('Invalid boolean string representation');
    }

    /**
     * Creates a Boolean instance from an integer.
     *
     * @param int $value The integer to convert (0 or 1)
     *
     * @return static A new instance
     *
     * @throws \InvalidArgumentException If the integer is not 0 or 1
     */
    final public static function fromInteger(int $value): static
    {
        if ($value === 1) {
            return new static(true);
        }
        if ($value === 0) {
            return new static(false);
        }
        throw new \InvalidArgumentException('Integer must be 0 or 1');
    }
}
