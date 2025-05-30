<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\String;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * EmailString - A string type for email addresses
 */
final class EmailString
{
    private string $value;

    /**
     * Create a new EmailString instance
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('EmailString must be a valid email address');
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