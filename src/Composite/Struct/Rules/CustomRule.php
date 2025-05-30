<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct\Rules;

use Nejcc\PhpDatatypes\Composite\Struct\ValidationRule;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;
use Closure;

class CustomRule implements ValidationRule
{
    private Closure $validator;
    private string $errorMessage;

    /**
     * Create a new custom validation rule
     *
     * @param Closure $validator A closure that takes a value and returns bool
     * @param string $errorMessage The error message to show if validation fails
     */
    public function __construct(Closure $validator, string $errorMessage)
    {
        $this->validator = $validator;
        $this->errorMessage = $errorMessage;
    }

    public function validate(mixed $value, string $fieldName): bool
    {
        $isValid = ($this->validator)($value);
        
        if (!$isValid) {
            throw new ValidationException(
                "Field '$fieldName': {$this->errorMessage}"
            );
        }

        return true;
    }
} 