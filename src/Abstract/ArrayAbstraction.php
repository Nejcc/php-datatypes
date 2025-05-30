<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Abstract;

abstract class ArrayAbstraction implements \Countable, \IteratorAggregate
{
    protected array $value;

    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function count(): int
    {
        return count($this->value);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->value);
    }

    public function toArray(): array
    {
        return $this->value;
    }

    // Add this for use by FloatArray and similar subclasses
    protected function validateFloats(array $array): void
    {
        foreach ($array as $item) {
            if (!is_float($item)) {
                throw new \Nejcc\PhpDatatypes\Exceptions\InvalidFloatException("All elements must be floats. Invalid value: " . json_encode($item));
            }
        }
    }

    protected function validateStrings(array $array): void
    {
        foreach ($array as $item) {
            if (!is_string($item)) {
                throw new \Nejcc\PhpDatatypes\Exceptions\InvalidStringException("All elements must be strings. Invalid value: " . json_encode($item));
            }
        }
    }

    protected function validateBytes(array $array): void
    {
        foreach ($array as $item) {
            if (!is_int($item) || $item < 0 || $item > 255) {
                throw new \Nejcc\PhpDatatypes\Exceptions\InvalidByteException("All elements must be valid bytes (0-255). Invalid value: " . $item);
            }
        }
    }

    protected function validateJson(string $json): void
    {
        try {
            json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \InvalidArgumentException('Invalid JSON provided: ' . $e->getMessage());
        }
    }

}
