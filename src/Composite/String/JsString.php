<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\String;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * JsString - A string type for JavaScript strings
 */
final class JsString
{
    private string $value;

    /**
     * Create a new JsString instance
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        // Relaxed JavaScript validation: allow printable characters, common JS symbols, whitespace
        if (!preg_match('/^[\x20-\x7E\t\n\r]+$/', $value)) {
            throw new InvalidArgumentException('Invalid JavaScript string format');
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