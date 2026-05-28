<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct\Rules;

use Nejcc\PhpDatatypes\Composite\Struct\ValidationRule;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;

final class UrlRule implements ValidationRule
{
    private bool $requireHttps;

    public function __construct(bool $requireHttps = false)
    {
        $this->requireHttps = $requireHttps;
    }

    public function validate(mixed $value, string $fieldName): bool
    {
        if (!is_string($value)) {
            throw new ValidationException(
                "Field '$fieldName' must be a string to validate URL"
            );
        }

        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new ValidationException(
                "Field '$fieldName' must be a valid URL"
            );
        }

        if ($this->requireHttps && !str_starts_with($value, 'https://')) {
            throw new ValidationException(
                "Field '$fieldName' must be a secure HTTPS URL"
            );
        }

        return true;
    }
}
