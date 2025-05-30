<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\String;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * UrlString - A string type for valid URLs
 */
final class UrlString
{
    private string $value;

    /**
     * Create a new UrlString instance
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('UrlString must be a valid URL');
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