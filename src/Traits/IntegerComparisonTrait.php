<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Traits;

use Nejcc\PhpDatatypes\Interfaces\NativeIntegerInterface;

trait IntegerComparisonTrait
{
    /**
     * Checks if this integer is equal to another integer.
     *
     * @param NativeIntegerInterface $other The integer to compare with.
     * @return bool True if equal, false otherwise.
     */
    public function equals(NativeIntegerInterface $other): bool
    {
        return $this->compare($other) === 0;
    }
}
