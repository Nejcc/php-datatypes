<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\String;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * Utf8String - A string type for UTF-8 encoded strings
 */
final class Utf8String
{
    private string $value;

    /**
     * Create a new Utf8String instance
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (!mb_check_encoding($value, 'UTF-8')) {
            throw new InvalidArgumentException('Utf8String must be a valid UTF-8 string');
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