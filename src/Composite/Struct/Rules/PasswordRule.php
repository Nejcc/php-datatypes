<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct\Rules;

use Nejcc\PhpDatatypes\Composite\Struct\ValidationRule;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;

class PasswordRule implements ValidationRule
{
    private int $minLength;
    private bool $requireUppercase;
    private bool $requireLowercase;
    private bool $requireNumbers;
    private bool $requireSpecialChars;
    private ?int $maxLength;

    public function __construct(
        int $minLength = 8,
        bool $requireUppercase = true,
        bool $requireLowercase = true,
        bool $requireNumbers = true,
        bool $requireSpecialChars = true,
        ?int $maxLength = null
    ) {
        $this->minLength = $minLength;
        $this->requireUppercase = $requireUppercase;
        $this->requireLowercase = $requireLowercase;
        $this->requireNumbers = $requireNumbers;
        $this->requireSpecialChars = $requireSpecialChars;
        $this->maxLength = $maxLength;
    }

    public function validate(mixed $value, string $fieldName): bool
    {
        if (!is_string($value)) {
            throw new ValidationException(
                "Field '$fieldName' must be a string to validate password"
            );
        }

        $length = strlen($value);
        if ($length < $this->minLength) {
            throw new ValidationException(
                "Field '$fieldName' must be at least {$this->minLength} characters long"
            );
        }

        if ($this->maxLength !== null && $length > $this->maxLength) {
            throw new ValidationException(
                "Field '$fieldName' must not exceed {$this->maxLength} characters"
            );
        }

        if ($this->requireUppercase && !preg_match('/[A-Z]/', $value)) {
            throw new ValidationException(
                "Field '$fieldName' must contain at least one uppercase letter"
            );
        }

        if ($this->requireLowercase && !preg_match('/[a-z]/', $value)) {
            throw new ValidationException(
                "Field '$fieldName' must contain at least one lowercase letter"
            );
        }

        if ($this->requireNumbers && !preg_match('/[0-9]/', $value)) {
            throw new ValidationException(
                "Field '$fieldName' must contain at least one number"
            );
        }

        if ($this->requireSpecialChars && !preg_match('/[^a-zA-Z0-9]/', $value)) {
            throw new ValidationException(
                "Field '$fieldName' must contain at least one special character"
            );
        }

        return true;
    }
} 