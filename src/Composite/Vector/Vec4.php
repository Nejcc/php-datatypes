<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Vector;

use Nejcc\PhpDatatypes\Abstract\AbstractVector;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

final class Vec4 extends AbstractVector
{
    public function getX(): float
    {
        return $this->getComponent(0);
    }

    public function getY(): float
    {
        return $this->getComponent(1);
    }

    public function getZ(): float
    {
        return $this->getComponent(2);
    }

    public function getW(): float
    {
        return $this->getComponent(3);
    }

    public static function zero(): self
    {
        return new self([0.0, 0.0, 0.0, 0.0]);
    }

    public static function unitX(): self
    {
        return new self([1.0, 0.0, 0.0, 0.0]);
    }

    public static function unitY(): self
    {
        return new self([0.0, 1.0, 0.0, 0.0]);
    }

    public static function unitZ(): self
    {
        return new self([0.0, 0.0, 1.0, 0.0]);
    }

    public static function unitW(): self
    {
        return new self([0.0, 0.0, 0.0, 1.0]);
    }

    public function getValue(): array
    {
        return $this->components;
    }

    public function setValue(mixed $value): void
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException('Value must be an array of components.');
        }
        $this->validateComponents($value);
        $this->components = $value;
    }
    protected function validateComponents(array $components): void
    {
        $this->validateComponentCount($components, 4);
        $this->validateNumericComponents($components);
    }
}
