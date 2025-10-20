<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Arrays;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\TypeMismatchException;

/**
 * DynamicArray - A type-safe array with dynamic capacity management.
 */
final class DynamicArray extends TypeSafeArray
{
    /**
     * @var int Current capacity of the array
     */
    private int $capacity;

    /**
     * Create a new DynamicArray instance
     *
     * @param string $elementType The type that all elements must conform to
     * @param int $initialCapacity The initial capacity of the array
     * @param array $initialData Optional initial data
     *
     * @throws InvalidArgumentException If elementType is invalid or capacity is non-positive
     * @throws TypeMismatchException If initial data contains invalid types
     */
    public function __construct(string $elementType, int $initialCapacity = 8, array $initialData = [])
    {
        if ($initialCapacity <= 0) {
            throw new InvalidArgumentException('Capacity must be a positive integer');
        }
        $this->capacity = $initialCapacity;
        parent::__construct($elementType, $initialData);
        if (count($initialData) > $this->capacity) {
            $this->capacity = count($initialData);
        }
    }

    /**
     * Get the current capacity
     *
     * @return int
     */
    public function getCapacity(): int
    {
        return $this->capacity;
    }

    /**
     * Reserve capacity for at least $capacity elements
     *
     * @param int $capacity
     *
     * @return void
     */
    public function reserve(int $capacity): void
    {
        if ($capacity > $this->capacity) {
            $this->capacity = $capacity;
        }
    }

    /**
     * Shrink the capacity to fit the current number of elements
     *
     * @return void
     */
    public function shrinkToFit(): void
    {
        $this->capacity = count($this->getValue());
    }

    /**
     * ArrayAccess implementation (override to grow capacity as needed)
     */
    public function offsetSet($offset, $value): void
    {
        if (!$this->isValidType($value)) {
            throw new TypeMismatchException(
                "Value must be of type {$this->getElementType()}"
            );
        }
        if (is_null($offset)) {
            // Appending
            if (count($this->getValue()) >= $this->capacity) {
                $this->capacity = max(1, $this->capacity * 2);
            }
        } else {
            if ($offset >= $this->capacity) {
                $this->capacity = $offset + 1;
            }
        }
        parent::offsetSet($offset, $value);
    }

    /**
     * Set the array value (override to adjust capacity)
     *
     * @param mixed $value
     *
     * @throws TypeMismatchException
     */
    public function setValue(mixed $value): void
    {
        if (!is_array($value)) {
            throw new TypeMismatchException('Value must be an array.');
        }
        if (count($value) > $this->capacity) {
            $this->capacity = count($value);
        }
        parent::setValue($value);
    }
}
