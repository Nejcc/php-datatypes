<?php

namespace Nejcc\PhpDatatypes\Exceptions;

use InvalidArgumentException as BaseInvalidArgumentException;

class InvalidArgumentException extends BaseInvalidArgumentException
{
    /**
     * Create a new invalid argument exception
     *
     * @param string $message The exception message
     * @param int $code The exception code
     * @param \Throwable|null $previous The previous exception
     */
    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Create an exception for invalid component count
     *
     * @param int $expected Expected number of components
     * @param int $actual Actual number of components
     * @return self
     */
    public static function invalidComponentCount(int $expected, int $actual): self
    {
        return new self(sprintf(
            'Invalid number of components. Expected %d, got %d',
            $expected,
            $actual
        ));
    }

    /**
     * Create an exception for non-numeric components
     *
     * @param array $components The invalid components
     * @return self
     */
    public static function nonNumericComponents(array $components): self
    {
        return new self(sprintf(
            'All components must be numeric. Got: %s',
            implode(', ', array_map('gettype', $components))
        ));
    }

    /**
     * Create an exception for different dimensions
     *
     * @param int $expected Expected dimension
     * @param int $actual Actual dimension
     * @return self
     */
    public static function differentDimensions(int $expected, int $actual): self
    {
        return new self(sprintf(
            'Vectors must have the same dimension. Expected %d, got %d',
            $expected,
            $actual
        ));
    }
} 