<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Floats;

final class Float32 extends AbstractFloat
{
    protected function getScale(): int
    {
        return 7; // Approximately 7 decimal digits of precision
    }

    public function add(FloatInterface $other): static
    {
        $result = bcadd((string)$this->value, (string)$other->getValue(), $this->getScale());
        return new static($result);
    }

    // Implement other arithmetic methods similarly
}
