<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Exceptions;

use Exception;

final class InvalidByteException extends Exception
{
    /**
     * Constructor for InvalidByteException.
     *
     * @param string $message The exception message.
     * @param int $code The exception code (default is 0).
     * @param Exception|null $previous Optional previous exception for chaining.
     */
    public function __construct(string $message = "Invalid byte value.", int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Customize the string representation of the exception.
     *
     * @return string The customized string for this exception.
     */
    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
