<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Laravel\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int32;

/**
 * Validation rule for Int32 values
 */
final class Int32Rule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        try {
            new Int32((int) $value);
            return true;
        } catch (\OutOfRangeException) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must be a valid 32-bit signed integer.';
    }
}
