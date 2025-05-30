<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\String;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * SlugString - A string type for URL-friendly slugs
 */
final class SlugString
{
    private string $value;

    /**
     * Create a new SlugString instance
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (!preg_match('/^[a-z0-9-]+$/', $value)) {
            throw new InvalidArgumentException('SlugString must contain only lowercase letters, numbers, and hyphens');
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