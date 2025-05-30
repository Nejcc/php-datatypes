<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Arrays;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\TypeMismatchException;

/**
 * FixedSizeArray - A type-safe array implementation that enforces both type constraints
 * and a fixed size on array elements.
 */
final class FixedSizeArray extends TypeSafeArray
{
    /**
     * @var int The fixed size of the array
     */
    private int $size;

    /**
     * Create a new FixedSizeArray instance
     *
     * @param string $elementType The type that all elements must conform to
     * @param int $size The fixed size of the array
     * @param array $initialData Optional initial data
     *
     * @throws InvalidArgumentException If elementType is invalid or size is non-positive
     * @throws TypeMismatchException If initial data contains invalid types or exceeds size
     */
    public function __construct(string $elementType, int $size, array $initialData = [])
    {
        if ($size <= 0) {
            throw new InvalidArgumentException('Size must be a positive integer');
        }

        if (count($initialData) > $size) {
            throw new InvalidArgumentException(
                "Initial data size ({$size}) exceeds fixed size ({$size})"
            );
        }

        $this->size = $size;
        parent::__construct($elementType, $initialData);
    }

    /**
     * Get the fixed size of the array
     *
     * @return int The fixed size
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Check if the array is full
     *
     * @return bool True if the array is at its maximum size
     */
    public function isFull(): bool
    {
        return count($this->getValue()) >= $this->size;
    }

    /**
     * Check if the array is empty
     *
     * @return bool True if the array has no elements
     */
    public function isEmpty(): bool
    {
        return count($this->getValue()) === 0;
    }

    /**
     * Get the number of remaining slots
     *
     * @return int The number of available slots
     */
    public function getRemainingSlots(): int
    {
        return $this->size - count($this->getValue());
    }

    /**
     * ArrayAccess implementation
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset) && $this->isFull()) {
            throw new InvalidArgumentException('Array is at maximum capacity');
        }

        if (!is_null($offset) && $offset >= $this->size) {
            throw new InvalidArgumentException(
                "Index {$offset} is out of bounds (size: {$this->size})"
            );
        }

        parent::offsetSet($offset, $value);
    }

    /**
     * Set the array value
     *
     * @param mixed $value The new array data
     *
     * @throws TypeMismatchException If any element doesn't match the required type
     * @throws InvalidArgumentException If the new array size exceeds the fixed size
     */
    public function setValue(mixed $value): void
    {
        if (!is_array($value)) {
            throw new TypeMismatchException('Value must be an array');
        }

        if (count($value) > $this->size) {
            throw new InvalidArgumentException(
                "New array size (" . count($value) . ") exceeds fixed size ({$this->size})"
            );
        }

        parent::setValue($value);
    }

    /**
     * Fill the array with a value up to its capacity
     *
     * @param mixed $value The value to fill with
     *
     * @return self
     *
     * @throws TypeMismatchException If the value doesn't match the required type
     */
    public function fill($value): self
    {
        if (!$this->isValidType($value)) {
            throw new TypeMismatchException(
                "Value must be of type {$this->getElementType()}"
            );
        }

        $this->setValue(array_fill(0, $this->size, $value));
        return $this;
    }

    /**
     * Create a new array with the same type and size
     *
     * @return self A new empty array with the same constraints
     */
    public function createEmpty(): self
    {
        return new self($this->getElementType(), $this->size);
    }
}
