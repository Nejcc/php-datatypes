<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct\Rules;

use Nejcc\PhpDatatypes\Composite\Struct\ValidationRule;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;

class PatternRule implements ValidationRule
{
    private string $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function validate(mixed $value, string $fieldName): bool
    {
        if (!is_string($value)) {
            throw new ValidationException(
                "Field '$fieldName' must be a string to validate pattern"
            );
        }

        if (!preg_match($this->pattern, $value)) {
            throw new ValidationException(
                "Field '$fieldName' does not match the required pattern"
            );
        }

        return true;
    }
} 