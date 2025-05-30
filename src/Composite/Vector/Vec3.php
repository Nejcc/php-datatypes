<?php

namespace Nejcc\PhpDatatypes\Composite\Vector;

use Nejcc\PhpDatatypes\Abstract\AbstractVector;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

class Vec3 extends AbstractVector
{
    protected function validateComponents(array $components): void
    {
        $this->validateComponentCount($components, 3);
        $this->validateNumericComponents($components);
    }

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

    public function cross(Vec3 $other): self
    {
        return new self([
            $this->getY() * $other->getZ() - $this->getZ() * $other->getY(),
            $this->getZ() * $other->getX() - $this->getX() * $other->getZ(),
            $this->getX() * $other->getY() - $this->getY() * $other->getX()
        ]);
    }

    public static function zero(): self
    {
        return new self([0.0, 0.0, 0.0]);
    }

    public static function unitX(): self
    {
        return new self([1.0, 0.0, 0.0]);
    }

    public static function unitY(): self
    {
        return new self([0.0, 1.0, 0.0]);
    }

    public static function unitZ(): self
    {
        return new self([0.0, 0.0, 1.0]);
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
} 