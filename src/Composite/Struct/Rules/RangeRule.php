<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct\Rules;

use Nejcc\PhpDatatypes\Composite\Struct\ValidationRule;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;

class RangeRule implements ValidationRule
{
    private float $min;
    private float $max;

    public function __construct(float $min, float $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function validate(mixed $value, string $fieldName): bool
    {
        if (!is_numeric($value)) {
            throw new ValidationException(
                "Field '$fieldName' must be numeric to validate range"
            );
        }

        $numValue = (float)$value;
        if ($numValue < $this->min || $numValue > $this->max) {
            throw new ValidationException(
                "Field '$fieldName' must be between {$this->min} and {$this->max}"
            );
        }

        return true;
    }
} 