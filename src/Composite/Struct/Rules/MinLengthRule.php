<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct\Rules;

use Nejcc\PhpDatatypes\Composite\Struct\ValidationRule;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;

final class MinLengthRule implements ValidationRule
{
    private int $minLength;

    public function __construct(int $minLength)
    {
        $this->minLength = $minLength;
    }

    public function validate(mixed $value, string $fieldName): bool
    {
        if (!is_string($value)) {
            throw new ValidationException(
                "Field '$fieldName' must be a string to validate length"
            );
        }

        if (strlen($value) < $this->minLength) {
            throw new ValidationException(
                "Field '$fieldName' must be at least {$this->minLength} characters long"
            );
        }

        return true;
    }
}
