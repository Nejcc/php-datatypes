<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Integers\Unsigned;

use Nejcc\PhpDatatypes\Abstract\AbstractInteger;
use Nejcc\PhpDatatypes\Interfaces\IntegerInterface;

final class UInt8 extends AbstractInteger
{
    protected function getMinValue(): int|string
    {
        return 0;
    }

    protected function getMaxValue(): int|string
    {
        return 255;
    }

    public function add(IntegerInterface $other): static
    {
        $result = $this->value + $other->getValue();
        return new static($result);
    }
}
