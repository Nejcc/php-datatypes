<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\String;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * CommandString - A string type for command line strings
 */
final class CommandString
{
    private string $value;

    /**
     * Create a new CommandString instance
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        // Basic command validation
        if (!preg_match('/^[a-zA-Z0-9_\-\.\/\\:;|&<>()\'"`\s]+$/', $value)) {
            throw new InvalidArgumentException('Invalid command string format');
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