<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct\Rules;

use Nejcc\PhpDatatypes\Composite\Struct\ValidationRule;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;

final class SlugRule implements ValidationRule
{
    private int $minLength;
    private int $maxLength;
    private bool $allowUnderscores;

    public function __construct(
        int $minLength = 3,
        int $maxLength = 100,
        bool $allowUnderscores = true
    ) {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
        $this->allowUnderscores = $allowUnderscores;
    }

    public function validate(mixed $value, string $fieldName): bool
    {
        if (!is_string($value)) {
            throw new ValidationException(
                "Field '$fieldName' must be a string to validate slug"
            );
        }

        $length = strlen($value);
        if ($length < $this->minLength) {
            throw new ValidationException(
                "Field '$fieldName' must be at least {$this->minLength} characters long"
            );
        }

        if ($length > $this->maxLength) {
            throw new ValidationException(
                "Field '$fieldName' must not exceed {$this->maxLength} characters"
            );
        }

        // Basic slug pattern: lowercase letters, numbers, hyphens, and optionally underscores
        $pattern = $this->allowUnderscores
            ? '/^[a-z0-9][a-z0-9-_]*[a-z0-9]$/'
            : '/^[a-z0-9][a-z0-9-]*[a-z0-9]$/';

        if (!preg_match($pattern, $value)) {
            $message = $this->allowUnderscores
                ? "Field '$fieldName' must contain only lowercase letters, numbers, hyphens, and underscores"
                : "Field '$fieldName' must contain only lowercase letters, numbers, and hyphens";
            throw new ValidationException($message);
        }

        // Check for consecutive hyphens or underscores
        if (str_contains($value, '--') || ($this->allowUnderscores && str_contains($value, '__'))) {
            throw new ValidationException(
                "Field '$fieldName' must not contain consecutive hyphens or underscores"
            );
        }

        return true;
    }
}
