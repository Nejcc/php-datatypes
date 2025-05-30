<?php

namespace Nejcc\PhpDatatypes\Abstract;

use Nejcc\PhpDatatypes\Interfaces\DataTypeInterface;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

abstract class AbstractVector implements DataTypeInterface
{
    protected array $components;

    public function __construct(array $components)
    {
        $this->validateComponents($components);
        $this->components = $components;
    }

    abstract protected function validateComponents(array $components): void;

    public function getComponents(): array
    {
        return $this->components;
    }

    public function magnitude(): float
    {
        return sqrt(array_sum(array_map(fn($component) => $component ** 2, $this->components)));
    }

    public function normalize(): self
    {
        $magnitude = $this->magnitude();
        if ($magnitude === 0.0) {
            throw new InvalidArgumentException("Cannot normalize a zero vector");
        }
        
        $normalized = array_map(fn($component) => $component / $magnitude, $this->components);
        return new static($normalized);
    }

    public function dot(self $other): float
    {
        if (get_class($this) !== get_class($other)) {
            throw new InvalidArgumentException("Cannot calculate dot product of vectors with different dimensions");
        }

        return array_sum(array_map(
            fn($a, $b) => $a * $b,
            $this->components,
            $other->components
        ));
    }

    public function add(self $other): self
    {
        if (get_class($this) !== get_class($other)) {
            throw new InvalidArgumentException("Cannot add vectors with different dimensions");
        }

        $result = array_map(
            fn($a, $b) => $a + $b,
            $this->components,
            $other->components
        );

        return new static($result);
    }

    public function subtract(self $other): self
    {
        if (get_class($this) !== get_class($other)) {
            throw new InvalidArgumentException("Cannot subtract vectors with different dimensions");
        }

        $result = array_map(
            fn($a, $b) => $a - $b,
            $this->components,
            $other->components
        );

        return new static($result);
    }

    public function scale(float $scalar): self
    {
        $result = array_map(
            fn($component) => $component * $scalar,
            $this->components
        );

        return new static($result);
    }

    public function __toString(): string
    {
        return '(' . implode(', ', $this->components) . ')';
    }

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

        $squaredDiff = array_map(
            fn($a, $b) => ($a - $b) ** 2,
            $this->components,
            $other->components
        );

        return sqrt(array_sum($squaredDiff));
    }
} 