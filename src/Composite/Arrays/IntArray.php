<?php

namespace Nejcc\PhpDatatypes\Composite\Arrays;

class IntArray {
    private array $value;

    public function __construct(array $value) {
        foreach ($value as $item) {
            if (!is_int($item)) {
                throw new \InvalidArgumentException("All elements must be integers.");
            }
        }
        $this->value = $value;
    }

    public function getValue(): array {
        return $this->value;
    }
}
