<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Abstract;

use OutOfRangeException;

abstract class AbstractFloat
{
    protected readonly float $value;

    public const MIN_VALUE = null;
    public const MAX_VALUE = null;

    public function __construct(float $value)
    {
        $this->setValue($value);
    }

    protected function setValue(float $value): void
    {
        // Check if value is out of range
        if ($value < static::MIN_VALUE || $value > static::MAX_VALUE) {
            throw new OutOfRangeException(sprintf(
                'Value %f is out of range for this float type. Allowed range: [%f, %f]',
                $value,
                static::MIN_VALUE,
                static::MAX_VALUE
            ));
        }

        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
