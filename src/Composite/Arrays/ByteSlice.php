<?php

namespace Nejcc\PhpDatatypes\Composite\Arrays;

class ByteSlice {
    private array $value;

    public function __construct(array $value) {
        foreach ($value as $item) {
            if (!is_int($item) || $item < 0 || $item > 255) {
                throw new \InvalidArgumentException("All elements must be valid bytes (0-255).");
            }
        }
        $this->value = $value;
    }

    public function getValue(): array {
        return $this->value;
    }
}
