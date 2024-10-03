<?php

namespace Nejcc\PhpDatatypes\Composite;

use OutOfBoundsException;

class ListData
{
    private array $elements;

    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    // Add an element to the list
    public function add($element): void
    {
        $this->elements[] = $element;
    }

    // Remove an element by its index
    public function remove(int $index): void
    {
        if (!isset($this->elements[$index])) {
            throw new OutOfBoundsException("No element at index $index.");
        }

        array_splice($this->elements, $index, 1);
    }

    // Get an element by its index
    public function get(int $index)
    {
        if (!isset($this->elements[$index])) {
            throw new OutOfBoundsException("No element at index $index.");
        }

        return $this->elements[$index];
    }

    // Get the entire list as an array
    public function getAll(): array
    {
        return $this->elements;
    }

    // Check if the list contains an element
    public function contains($element): bool
    {
        return in_array($element, $this->elements, true);
    }

    // Get the size of the list
    public function size(): int
    {
        return count($this->elements);
    }

    // Clear the list
    public function clear(): void
    {
        $this->elements = [];
    }
}
