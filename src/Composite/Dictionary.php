<?php
declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite;

use InvalidArgumentException;
use OutOfBoundsException;

class Dictionary
{
    /**
     * The associative array that stores dictionary elements.
     *
     * @var array<string, mixed>
     */
    private array $elements;

    /**
     * Create a new dictionary instance.
     *
     * Validates that the initial elements are associative.
     *
     * @param array<string, mixed> $elements
     * @throws InvalidArgumentException
     * @return void
     */
    public function __construct(array $elements = [])
    {
        foreach ($elements as $key => $value) {
            if (is_int($key)) {
                throw new InvalidArgumentException("Dictionary keys must be non-integer (string) keys.");
            }
        }

        $this->elements = $elements;
    }

    /**
     * Add a key-value pair to the dictionary.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function add(string $key, mixed $value): void
    {
        $this->elements[$key] = $value;
    }

    /**
     * Get the value associated with a key.
     *
     * @param string $key
     * @throws OutOfBoundsException
     * @return mixed
     */
    public function get(string $key): mixed
    {
        if (!isset($this->elements[$key])) {
            throw new OutOfBoundsException("Key '$key' does not exist in the dictionary.");
        }

        return $this->elements[$key];
    }

    /**
     * Remove a key-value pair by the key.
     *
     * @param string $key
     * @throws OutOfBoundsException
     * @return void
     */
    public function remove(string $key): void
    {
        if (!isset($this->elements[$key])) {
            throw new OutOfBoundsException("Key '$key' does not exist in the dictionary.");
        }

        unset($this->elements[$key]);
    }

    /**
     * Check if a key exists in the dictionary.
     *
     * @param string $key
     * @return bool
     */
    public function containsKey(string $key): bool
    {
        return array_key_exists($key, $this->elements);
    }

    /**
     * Get all keys in the dictionary.
     *
     * @return array<string>
     */
    public function getKeys(): array
    {
        return array_keys($this->elements);
    }

    /**
     * Get all values in the dictionary.
     *
     * @return array<mixed>
     */
    public function getValues(): array
    {
        return array_values($this->elements);
    }

    /**
     * Get the size of the dictionary.
     *
     * @return int
     */
    public function size(): int
    {
        return count($this->elements);
    }

    /**
     * Clear all elements in the dictionary.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->elements = [];
    }
}
