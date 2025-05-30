<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\String;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * PathString - A string type for file path strings
 */
final class PathString
{
    private string $value;

    /**
     * Create a new PathString instance
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        // Basic path validation
        if (!preg_match('/^[a-zA-Z0-9_\-\.\/\\:]+$/', $value)) {
            throw new InvalidArgumentException('Invalid path string format');
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