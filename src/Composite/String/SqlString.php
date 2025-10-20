<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\String;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * SqlString - A string type for SQL strings
 */
final class SqlString
{
    private string $value;

    /**
     * Create a new SqlString instance
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        // Relaxed SQL validation: allow printable characters, whitespace, and common SQL symbols
        if (!preg_match('/^[\x20-\x7E\t\n\r]+$/', $value)) {
            throw new InvalidArgumentException('Invalid SQL string format');
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