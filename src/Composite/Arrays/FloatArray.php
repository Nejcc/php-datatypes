<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Arrays;

use Countable;
use ArrayAccess;
use IteratorAggregate;
use Traversable;
use Nejcc\PhpDatatypes\Exceptions\InvalidFloatException;

readonly class FloatArray implements Countable, ArrayAccess, IteratorAggregate
{
    /**
     * @var array<float> The float values.
     */
    private array $value;

    /**
     * Constructor for FloatArray.
     *
     * @param array<float> $value The array of float values.
     * @throws InvalidFloatException If any value is not a valid float.
     */
    public function __construct(array $value)
    {
        $this->validateFloats($value);
        $this->value = $value;
    }

    /**
     * Validate that all elements are floats.
     *
     * @param array $array The array to validate.
     * @throws InvalidFloatException If any element is not a valid float.
     * @return void
     */
    private function validateFloats(array $array): void
    {
        foreach ($array as $item) {
            if (!is_float($item)) {
                throw new InvalidFloatException("All elements must be floats. Invalid value: " . json_encode($item));
            }
        }
    }

    /**
     * Get the array of float values.
     *
     * @return array<float> The float array.
     */
    public function getValue(): array
    {
        return $this->value;
    }

    /**
     * Get the float at a specific index.
     *
     * @param int $index The index.
     * @return float|null The float value or null if index is out of bounds.
     */
    public function getFloat(int $index): ?float
    {
        return $this->value[$index] ?? null;
    }

    /**
     * Get the count of floats in the array.
     *
     * @return int The number of floats.
     */
    public function count(): int
    {
        return count($this->value);
    }

    /**
     * Calculate the sum of the float array.
     *
     * @return float The sum of the floats.
     */
    public function sum(): float
    {
        return array_sum($this->value);
    }

    /**
     * Calculate the average of the float array.
     *
     * @return float The average value of the floats.
     * @throws InvalidFloatException If the array is empty.
     */
    public function average(): float
    {
        if ($this->count() === 0) {
            throw new InvalidFloatException("Cannot calculate average of an empty array.");
        }
        return $this->sum() / $this->count();
    }

    /**
     * Add new floats to the array (returns a new instance).
     *
     * @param float ...$floats The floats to add.
     * @return FloatArray The new FloatArray with added floats.
     * @throws InvalidFloatException If any value is not a valid float.
     */
    public function add(float ...$floats): self
    {
        $this->validateFloats($floats);
        return new self(array_merge($this->value, $floats));
    }

    /**
     * Remove specific floats from the array (returns a new instance).
     *
     * @param float ...$floats The floats to remove.
     * @return FloatArray The new FloatArray with removed floats.
     * @throws InvalidFloatException
     */
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

    /**
     * ArrayAccess: Check if a float exists at the given offset.
     *
     * @param int $offset The array offset.
     * @return bool True if offset exists, false otherwise.
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->value[$offset]);
    }

    /**
     * ArrayAccess: Get the float at the given offset.
     *
     * @param int $offset The array offset.
     * @return float|null The float value or null if index does not exist.
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->value[$offset] ?? null;
    }

    /**
     * ArrayAccess: Prevent modification by throwing an exception.
     *
     * @param mixed $offset The array offset.
     * @param mixed $value The value to set (not allowed).
     * @throws InvalidFloatException Always thrown since FloatArray is immutable.
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new InvalidFloatException("Cannot modify an immutable FloatArray.");
    }

    /**
     * ArrayAccess: Prevent unsetting by throwing an exception.
     *
     * @param int $offset The array offset.
     * @throws InvalidFloatException Always thrown since FloatArray is immutable.
     */
    public function offsetUnset(mixed $offset): void
    {
        throw new InvalidFloatException("Cannot unset a value in an immutable FloatArray.");
    }

    /**
     * Get an iterator for the float array.
     *
     * @return Traversable An iterator for the float array.
     */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->value);
    }
}
