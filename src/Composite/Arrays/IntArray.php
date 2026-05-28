<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Arrays;

use Nejcc\PhpDatatypes\Abstract\ArrayAbstraction;

final class IntArray extends ArrayAbstraction
{
    public function __construct(array $value, bool $trusted = false)
    {
        if (!$trusted) {
            foreach ($value as $item) {
                if (!is_int($item)) {
                    throw new \InvalidArgumentException('All elements must be integers. Invalid value: ' . json_encode($item));
                }
            }
        }
        parent::__construct($value);
    }

    /**
     * Construct without validation. Caller must guarantee every element is an int.
     * Use only in performance-critical paths where the input is already trusted.
     */
    public static function fromTrusted(array $value): self
    {
        return new self($value, true);
    }

    public function get(int $index): int
    {
        if (!isset($this->value[$index])) {
            throw new \OutOfRangeException("Index out of range");
        }
        return $this->value[$index];
    }

    public function set(int $index, int $value): void
    {
        if (!isset($this->value[$index])) {
            throw new \OutOfRangeException("Index out of range");
        }
        $this->value[$index] = $value;
    }

    public function append(int $value): void
    {
        $this->value[] = $value;
    }
}
