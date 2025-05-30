<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Arrays;

use Nejcc\PhpDatatypes\Abstract\ArrayAbstraction;
use Nejcc\PhpDatatypes\Exceptions\InvalidFloatException;

class FloatArray extends ArrayAbstraction implements \ArrayAccess
{
    public function __construct(array $value)
    {
        $this->validateFloats($value);
        parent::__construct($value);
    }

    public function get(int $index): ?float
    {
        return $this->value[$index] ?? null;
    }

    public function sum(): float
    {
        return array_sum($this->value);
    }

    public function average(): float
    {
        if ($this->count() === 0) {
            throw new InvalidFloatException("Cannot calculate average of an empty array.");
        }
        return $this->sum() / $this->count();
    }

    public function add(float ...$floats): self
    {
        $this->validateFloats($floats);
        return new self(array_merge($this->value, $floats));
    }

    public function remove(float ...$floats): self
    {
        $newArray = $this->value;
        foreach ($floats as $float) {
            $index = array_search($float, $newArray, true);
            if ($index !== false) {
                unset($newArray[$index]);
            }
        }
        return new self(array_values($newArray));
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->value[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->value[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new InvalidFloatException("Cannot modify an immutable FloatArray.");
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new InvalidFloatException("Cannot unset a value in an immutable FloatArray.");
    }
}
