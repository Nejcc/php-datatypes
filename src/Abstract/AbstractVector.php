<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Abstract;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Interfaces\DataTypeInterface;

abstract class AbstractVector implements DataTypeInterface
{
    protected array $components;

    /**
     * @param array $components
     * @param bool $trusted Internal use only. When true, skips component validation.
     *                     Used by arithmetic ops whose result is known to be valid
     *                     (same dimension, all numeric) by construction.
     */
    public function __construct(array $components, bool $trusted = false)
    {
        if (!$trusted) {
            $this->validateComponents($components);
        }
        $this->components = $components;
    }

    public function __toString(): string
    {
        return '(' . implode(', ', $this->components) . ')';
    }

    public function getComponents(): array
    {
        return $this->components;
    }

    public function magnitude(): float
    {
        $sum = 0.0;
        foreach ($this->components as $c) {
            $sum += $c * $c;
        }
        return sqrt($sum);
    }

    public function normalize(): self
    {
        $magnitude = $this->magnitude();
        if ($magnitude === 0.0) {
            throw new InvalidArgumentException("Cannot normalize a zero vector");
        }

        $result = [];
        foreach ($this->components as $i => $c) {
            $result[$i] = $c / $magnitude;
        }
        return new static($result, true);
    }

    public function dot(self $other): float
    {
        if (get_class($this) !== get_class($other)) {
            throw new InvalidArgumentException("Cannot calculate dot product of vectors with different dimensions");
        }

        $sum = 0.0;
        $b = $other->components;
        foreach ($this->components as $i => $a) {
            $sum += $a * $b[$i];
        }
        return $sum;
    }

    public function add(self $other): self
    {
        if (get_class($this) !== get_class($other)) {
            throw new InvalidArgumentException("Cannot add vectors with different dimensions");
        }

        $result = [];
        $b = $other->components;
        foreach ($this->components as $i => $a) {
            $result[$i] = $a + $b[$i];
        }
        return new static($result, true);
    }

    public function subtract(self $other): self
    {
        if (get_class($this) !== get_class($other)) {
            throw new InvalidArgumentException("Cannot subtract vectors with different dimensions");
        }

        $result = [];
        $b = $other->components;
        foreach ($this->components as $i => $a) {
            $result[$i] = $a - $b[$i];
        }
        return new static($result, true);
    }

    public function scale(float $scalar): self
    {
        $result = [];
        foreach ($this->components as $i => $c) {
            $result[$i] = $c * $scalar;
        }
        return new static($result, true);
    }

    public function getComponent(int $index): float
    {
        if (!isset($this->components[$index])) {
            throw new InvalidArgumentException("Invalid component index");
        }
        return $this->components[$index];
    }

    public function equals(DataTypeInterface $other): bool
    {
        if (!$other instanceof self) {
            return false;
        }

        return $this->components === $other->components;
    }

    public function distance(self $other): float
    {
        if (get_class($this) !== get_class($other)) {
            throw new InvalidArgumentException("Cannot calculate distance between vectors with different dimensions");
        }

        $sum = 0.0;
        $b = $other->components;
        foreach ($this->components as $i => $a) {
            $diff = $a - $b[$i];
            $sum += $diff * $diff;
        }
        return sqrt($sum);
    }

    abstract protected function validateComponents(array $components): void;

    protected function validateNumericComponents(array $components): void
    {
        foreach ($components as $component) {
            if (!is_numeric($component)) {
                throw new InvalidArgumentException("All components must be numeric");
            }
        }
    }

    protected function validateComponentCount(array $components, int $expectedCount): void
    {
        if (count($components) !== $expectedCount) {
            throw new InvalidArgumentException(sprintf(
                "Vector must have exactly %d components",
                $expectedCount
            ));
        }
    }
}
