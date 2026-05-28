<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Vector;

use Nejcc\PhpDatatypes\Abstract\AbstractVector;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

final class Vec2 extends AbstractVector
{
    public function getX(): float
    {
        return $this->getComponent(0);
    }

    public function getY(): float
    {
        return $this->getComponent(1);
    }

    public function cross(Vec2 $other): float
    {
        return ($this->getX() * $other->getY()) - ($this->getY() * $other->getX());
    }

    public static function zero(): self
    {
        return new self([0.0, 0.0]);
    }

    public static function unitX(): self
    {
        return new self([1.0, 0.0]);
    }

    public static function unitY(): self
    {
        return new self([0.0, 1.0]);
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
        $this->validateComponentCount($components, 2);
        $this->validateNumericComponents($components);
    }

    public function add(AbstractVector $other): self
    {
        if (!$other instanceof self) {
            throw new InvalidArgumentException("Cannot add vectors with different dimensions");
        }
        $a = $this->components;
        $b = $other->components;
        return new self([$a[0] + $b[0], $a[1] + $b[1]], true);
    }

    public function subtract(AbstractVector $other): self
    {
        if (!$other instanceof self) {
            throw new InvalidArgumentException("Cannot subtract vectors with different dimensions");
        }
        $a = $this->components;
        $b = $other->components;
        return new self([$a[0] - $b[0], $a[1] - $b[1]], true);
    }

    public function scale(float $scalar): self
    {
        $a = $this->components;
        return new self([$a[0] * $scalar, $a[1] * $scalar], true);
    }

    public function dot(AbstractVector $other): float
    {
        if (!$other instanceof self) {
            throw new InvalidArgumentException("Cannot calculate dot product of vectors with different dimensions");
        }
        $a = $this->components;
        $b = $other->components;
        return $a[0] * $b[0] + $a[1] * $b[1];
    }

    public function magnitude(): float
    {
        $a = $this->components;
        return sqrt($a[0] * $a[0] + $a[1] * $a[1]);
    }

    public function distance(AbstractVector $other): float
    {
        if (!$other instanceof self) {
            throw new InvalidArgumentException("Cannot calculate distance between vectors with different dimensions");
        }
        $a = $this->components;
        $b = $other->components;
        $dx = $a[0] - $b[0];
        $dy = $a[1] - $b[1];
        return sqrt($dx * $dx + $dy * $dy);
    }

    public function normalize(): self
    {
        $a = $this->components;
        $mag = sqrt($a[0] * $a[0] + $a[1] * $a[1]);
        if ($mag === 0.0) {
            throw new InvalidArgumentException("Cannot normalize a zero vector");
        }
        return new self([$a[0] / $mag, $a[1] / $mag], true);
    }
}
