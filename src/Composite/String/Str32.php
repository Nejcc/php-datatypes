<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\String;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * Str32 - A string type for 32-character hex strings
 */
final class Str32
{
    private string $value;

    /**
     * Create a new Str32 instance
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (strlen($value) !== 32) {
            throw new InvalidArgumentException('Str32 must be exactly 32 characters long');
        }
        if (!ctype_xdigit($value)) {
            throw new InvalidArgumentException('Str32 must be a valid hex string');
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