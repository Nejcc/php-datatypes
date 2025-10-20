<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\String;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * Base64String - A string type for base64 encoded strings
 */
final class Base64String
{
    private string $value;

    /**
     * Create a new Base64String instance
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (!preg_match('/^[A-Za-z0-9+\/=]+$/', $value)) {
            throw new InvalidArgumentException('Invalid base64 string format');
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