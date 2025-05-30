<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Traits;

use Nejcc\PhpDatatypes\Interfaces\BigIntegerInterface;

trait BigIntegerComparisonTrait
{
    /**
     * @param BigIntegerInterface $other
     * @return bool
     */
    public function equals(BigIntegerInterface $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    /**
     * @param BigIntegerInterface $other
     * @return bool
     */
    public function isGreaterThan(BigIntegerInterface $other): bool
    {
        return $this->getValue() > $other->getValue();
    }

    /**
     * @param BigIntegerInterface $other
     * @return bool
     */
    public function isLessThan(BigIntegerInterface $other): bool
    {
        return $this->getValue() < $other->getValue();
    }
} 