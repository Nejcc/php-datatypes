<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Abstract;

/**
 * Abstract base for Char-like types (single character).
 */
abstract class AbstractChar
{
    /**
     * @var string
     */
    protected string $value;

    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (strlen($value) !== 1) {
            throw new \InvalidArgumentException('Char must be a single character.');
        }
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    final public function getValue(): string
    {
        return $this->value;
    }

    final public function toUpperCase(): static
    {
        return new static(strtoupper($this->value));
    }

    final public function toLowerCase(): static
    {
        return new static(strtolower($this->value));
    }

    final public function isLetter(): bool
    {
        return ctype_alpha($this->value);
    }

    final public function isDigit(): bool
    {
        return ctype_digit($this->value);
    }

    final public function isUpperCase(): bool
    {
        return ctype_upper($this->value);
    }

    final public function isLowerCase(): bool
    {
        return ctype_lower($this->value);
    }

    final public function isWhitespace(): bool
    {
        return ctype_space($this->value);
    }

    final public function getNumericValue(): int
    {
        return $this->isDigit() ? (int)$this->value : -1;
    }

    final public function equals(self $char): bool
    {
        return $this->value === $char->getValue();
    }

    final public function toAscii(): int
    {
        return ord($this->value);
    }

    final public static function fromAscii(int $ascii): static
    {
        if ($ascii < 0 || $ascii > 255) {
            throw new \InvalidArgumentException('ASCII value must be between 0 and 255.');
        }
        return new static(chr($ascii));
    }
}
