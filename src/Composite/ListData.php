<?php
declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite;

use OutOfBoundsException;

class ListData
{
    /**
     * The array that stores the list elements.
     *
     * @var array<int, mixed>
     */
    private array $elements;

    /**
     * Create a new ListData instance.
     *
     * @param array<int, mixed> $elements
     * @return void
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    /**
     * Add an element to the list.
     *
     * @param mixed $element
     * @return void
     */
    public function add(mixed $element): void
    {
        $this->elements[] = $element;
    }

    /**
     * Remove an element by its index.
     *
     * @param int $index
     * @throws OutOfBoundsException
     * @return void
     */
    public function remove(int $index): void
    {
        if (!isset($this->elements[$index])) {
            throw new OutOfBoundsException("No element at index $index.");
        }

        array_splice($this->elements, $index, 1);
    }

    /**
     * Get an element by its index.
     *
     * @param int $index
     * @throws OutOfBoundsException
     * @return mixed
     */
    public function get(int $index): mixed
    {
        if (!isset($this->elements[$index])) {
            throw new OutOfBoundsException("No element at index $index.");
        }

        return $this->elements[$index];
    }

    /**
     * Get the entire list as an array.
     *
     * @return array<int, mixed>
     */
    public function getAll(): array
    {
        return $this->elements;
    }

    /**
     * Check if the list contains an element.
     *
     * @param mixed $element
     * @return bool
     */
    public function contains(mixed $element): bool
    {
        return in_array($element, $this->elements, true);
    }

    /**
     * Get the size of the list.
     *
     * @return int
     */
    public function size(): int
    {
        return count($this->elements);
    }

    /**
     * Clear the list.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->elements = [];
    }
}
