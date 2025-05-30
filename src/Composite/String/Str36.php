<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\String;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * Str36 - A string type for UUID-like strings (36 characters)
 */
final class Str36
{
    private string $value;

    /**
     * Create a new Str36 instance
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (strlen($value) !== 36) {
            throw new InvalidArgumentException('Str36 must be exactly 36 characters long');
        }
        $this->value = $value;
    }

    /**
     * Get the string value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * String representation
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
} 