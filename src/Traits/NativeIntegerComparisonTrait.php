<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Traits;

use Nejcc\PhpDatatypes\Interfaces\NativeIntegerInterface;

trait NativeIntegerComparisonTrait
{
    /**
     * @param NativeIntegerInterface $other
     * @return bool
     */
    public function equals(NativeIntegerInterface $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    /**
     * @param NativeIntegerInterface $other
     * @return bool
     */
    public function isGreaterThan(NativeIntegerInterface $other): bool
    {
        return $this->getValue() > $other->getValue();
    }

    /**
     * @param NativeIntegerInterface $other
     * @return bool
     */
    public function isLessThan(NativeIntegerInterface $other): bool
    {
        return $this->getValue() < $other->getValue();
    }
}
