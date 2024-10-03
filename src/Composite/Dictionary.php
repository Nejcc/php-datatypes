<?php

namespace Nejcc\PhpDatatypes\Composite;

use InvalidArgumentException;
use OutOfBoundsException;

class Dictionary
{
    private array $elements;

    public function __construct(array $elements = [])
    {
        // Validate that the initial elements are associative
        foreach ($elements as $key => $value) {
            if (is_int($key)) {
                throw new InvalidArgumentException("Dictionary keys must be non-integer (string) keys.");
            }
        }

        $this->elements = $elements;
    }

    // Add a key-value pair to the dictionary
    public function add(string $key, $value): void
    {
        $this->elements[$key] = $value;
    }

    // Get the value associated with a key
    public function get(string $key)
    {
        if (!isset($this->elements[$key])) {
            throw new OutOfBoundsException("Key '$key' does not exist in the dictionary.");
        }

        return $this->elements[$key];
    }

    // Remove a key-value pair by the key
    public function remove(string $key): void
    {
        if (!isset($this->elements[$key])) {
            throw new OutOfBoundsException("Key '$key' does not exist in the dictionary.");
        }

        unset($this->elements[$key]);
    }

    // Check if a key exists in the dictionary
    public function containsKey(string $key): bool
    {
        return array_key_exists($key, $this->elements);
    }

    // Get all keys in the dictionary
    public function getKeys(): array
    {
        return array_keys($this->elements);
    }

    // Get all values in the dictionary
    public function getValues(): array
    {
        return array_values($this->elements);
    }

    // Get the size of the dictionary
    public function size(): int
    {
        return count($this->elements);
    }

    // Clear the dictionary
    public function clear(): void
    {
        $this->elements = [];
    }
}
