<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\String;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * Str16 - A string type for 16-character hex strings
 */
final class Str16
{
    private string $value;

    /**
     * Create a new Str16 instance
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (strlen($value) !== 16) {
            throw new InvalidArgumentException('Str16 must be exactly 16 characters long');
        }
        if (!ctype_xdigit($value)) {
            throw new InvalidArgumentException('Str16 must be a valid hex string');
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