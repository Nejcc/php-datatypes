<?php

namespace Nejcc\PhpDatatypes\Exceptions;

use Exception;
use Throwable;

class InvalidStringException extends Exception
{
    /**
     * @var mixed The invalid value that caused the exception.
     */
    private mixed $invalidValue;

    /**
     * InvalidStringException constructor.
     *
     * @param mixed $invalidValue The invalid value that caused the exception.
     * @param string|null $message Optional custom message for the exception.
     * @param int $code Optional exception code.
     * @param Throwable|null $previous Previous throwable for chaining exceptions.
     */
    public function __construct($invalidValue, string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        $this->invalidValue = $invalidValue;

        // Generate a more detailed default message if none is provided.
        $message = $message ?? "Invalid string value: " . json_encode($invalidValue);

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the invalid value that caused the exception.
     *
     * @return mixed The invalid value.
     */
    public function getInvalidValue(): mixed
    {
        return $this->invalidValue;
    }

    /**
     * String representation of the exception, including the invalid value.
     *
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}. Invalid value: " . json_encode($this->invalidValue) . "\n";
    }
}
