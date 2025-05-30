<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct;

/**
 * Interface for field validation rules
 */
interface ValidationRule
{
    /**
     * Validate a value against this rule
     *
     * @param mixed $value The value to validate
     * @param string $fieldName The name of the field being validated
     * @return bool True if the value passes validation
     * @throws \Nejcc\PhpDatatypes\Exceptions\ValidationException If validation fails
     */
    public function validate(mixed $value, string $fieldName): bool;
} 