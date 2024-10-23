<?php
declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Exceptions;

use Exception;

class InvalidFloatException extends Exception
{
    /**
     * Constructor for InvalidFloatException.
     *
     * @param string $message The exception message.
     * @param int $code The exception code (default is 0).
     * @param Exception|null $previous Optional previous exception for chaining.
     */
    public function __construct(string $message = "Invalid float value.", int $code = 0, ?Exception $previous = null)
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
