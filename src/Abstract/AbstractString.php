<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Abstract;

use Nejcc\PhpDatatypes\Interfaces\StringInterface;

/**
 * Abstract class for string types.
 *
 * @package Nejcc\PhpDatatypes\Abstract
 */
abstract class AbstractString implements StringInterface
{
    protected readonly string $value;

    /**
     * AbstractString constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    /**
     * Set the string value.
     *
     * @param string $value
     * @return void
     */
    protected function setValue(string $value): void
    {
        // Perform validations if necessary (e.g., length checks)
        $this->value = $value;
    }

    /**
     * Get the string value.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Compare two strings.
     *
     * @param StringInterface $other
     * @return int
     */
    public function compare(StringInterface $other): int
    {
        return strcmp($this->value, $other->getValue());
    }

    /**
     * Append another string to this one.
     *
     * @param StringInterface $other
     * @return static
     */
    public function append(StringInterface $other): static
    {
        return new static($this->value . $other->getValue());
    }

    /**
     * Get a substring of the current string.
     *
     * @param int $start
     * @param int|null $length
     * @return static
     */
    public function substring(int $start, ?int $length = null): static
    {
        return new static(substr($this->value, $start, $length));
    }

    /**
     * Check if this string contains another string.
     *
     * @param StringInterface $needle
     * @return bool
     */
    public function contains(StringInterface $needle): bool
    {
        return str_contains($this->value, $needle->getValue());
    }

    /**
     * Get the length of the string.
     *
     * @return int
     */
    public function length(): int
    {
        return strlen($this->value);
    }
}
