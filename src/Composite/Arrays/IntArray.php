<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Arrays;

use Nejcc\PhpDatatypes\Abstract\ArrayAbstraction;

final class IntArray extends ArrayAbstraction
{
    public function __construct(array $value)
    {
        foreach ($value as $item) {
            if (!is_int($item)) {
                throw new \InvalidArgumentException("All elements must be integers.");
            }
        }
        parent::__construct($value);
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
