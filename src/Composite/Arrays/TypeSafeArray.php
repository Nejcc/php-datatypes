<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Arrays;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\TypeMismatchException;
use Nejcc\PhpDatatypes\Interfaces\DataTypeInterface;

/**
 * TypeSafeArray - A type-safe array implementation that enforces type constraints
 * on array elements.
 */
class TypeSafeArray implements DataTypeInterface, \ArrayAccess, \Countable, \Iterator
{
    /**
     * @var array The internal array storage
     */
    private array $data;

    /**
     * @var string The type that all elements must conform to
     */
    private string $elementType;

    /**
     * @var int Current position for Iterator implementation
     */
    private int $position = 0;

    /**
     * Create a new TypeSafeArray instance
     *
     * @param string $elementType The type that all elements must conform to
     * @param array $initialData Optional initial data
     *
     * @throws InvalidArgumentException If elementType is invalid
     * @throws TypeMismatchException If initial data contains invalid types
     */
    public function __construct(string $elementType, array $initialData = [])
    {
        if (!class_exists($elementType) && !interface_exists($elementType)) {
            throw new InvalidArgumentException("Invalid element type: {$elementType}");
        }

        $this->elementType = $elementType;
        $this->data = [];

        if (!empty($initialData)) {
            $this->validateArray($initialData);
            $this->data = $initialData;
        }
    }

    /**
     * String representation of the array
     *
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->data);
    }

    /**
     * Get the type of elements this array accepts
     *
     * @return string The element type
     */
    public function getElementType(): string
    {
        return $this->elementType;
    }

    /**
     * Get all elements in the array
     *
     * @return array The array elements
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * ArrayAccess implementation
     */
    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if (!$this->isValidType($value)) {
            throw new TypeMismatchException(
                "Value must be of type {$this->elementType}"
            );
        }

        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    /**
     * Countable implementation
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * Iterator implementation
     */
    public function current(): mixed
    {
        return $this->data[$this->position];
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->data[$this->position]);
    }

    /**
     * Map operation - apply a callback to each element
     *
     * @param callable $callback The callback to apply
     *
     * @return TypeSafeArray A new array with the mapped values
     *
     * @throws TypeMismatchException If the callback returns invalid types
     */
    public function map(callable $callback): self
    {
        $result = new self($this->elementType);
        foreach ($this->data as $key => $value) {
            $result[$key] = $callback($value, $key);
        }
        return $result;
    }

    /**
     * Filter operation - filter elements based on a callback
     *
     * @param callable $callback The callback to use for filtering
     *
     * @return TypeSafeArray A new array with the filtered values
     */
    public function filter(callable $callback): self
    {
        $result = new self($this->elementType);
        foreach ($this->data as $key => $value) {
            if ($callback($value, $key)) {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * Reduce operation - reduce the array to a single value
     *
     * @param callable $callback The callback to use for reduction
     * @param mixed $initial The initial value
     *
     * @return mixed The reduced value
     */
    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->data, $callback, $initial);
    }

    /**
     * Get the array value
     *
     * @return array The array data
     */
    public function getValue(): array
    {
        return $this->data;
    }

    /**
     * Set the array value
     *
     * @param mixed $value The new array data
     *
     * @throws TypeMismatchException If any element doesn't match the required type
     */
    public function setValue(mixed $value): void
    {
        if (!is_array($value)) {
            throw new TypeMismatchException('Value must be an array.');
        }
        $this->validateArray($value);
        $this->data = $value;
    }

    /**
     * Check if this array equals another array
     *
     * @param DataTypeInterface $other The other array to compare with
     *
     * @return bool True if the arrays are equal
     */
    public function equals(DataTypeInterface $other): bool
    {
        if (!$other instanceof self) {
            return false;
        }

        if ($this->elementType !== $other->elementType) {
            return false;
        }

        return $this->data === $other->data;
    }

    /**
     * Check if a value matches the required type
     *
     * @param mixed $value The value to check
     *
     * @return bool True if the value matches the required type
     */
    protected function isValidType($value): bool
    {
        return $value instanceof $this->elementType;
    }

    /**
     * Validate that all elements in an array match the required type
     *
     * @param array $data The array to validate
     *
     * @throws TypeMismatchException If any element doesn't match the required type
     */
    private function validateArray(array $data): void
    {
        foreach ($data as $key => $value) {
            if (!$this->isValidType($value)) {
                throw new TypeMismatchException(
                    "Element at key '{$key}' must be of type {$this->elementType}"
                );
            }
        }
    }
}
