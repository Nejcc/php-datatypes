<?php

namespace Nejcc\PhpDatatypes\Composite;

use InvalidArgumentException;
use OutOfBoundsException;

class Dictionary
{
    /**
     * @var array
     */
    private array $elements = [];

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


    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public function add(string $key, $value): void
    {
        $this->elements[$key] = $value;
    }


    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        if (!isset($this->elements[$key])) {
            throw new OutOfBoundsException("Key '$key' does not exist in the dictionary.");
        }

        return $this->elements[$key];
    }


    /**
     * @param string $key
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
     * @param string $key
     * @return bool
     */
    public function containsKey(string $key): bool
    {
        return array_key_exists($key, $this->elements);
    }


    /**
     * @return array
     */
    public function getKeys(): array
    {
        return array_keys($this->elements);
    }


    /**
     * @return array
     */
    public function getValues(): array
    {
        return array_values($this->elements);
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return count($this->elements);
    }


    /**
     * @return void
     */
    public function clear(): void
    {
        $this->elements = [];
    }
}
