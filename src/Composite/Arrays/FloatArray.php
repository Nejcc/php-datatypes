<?php

namespace Nejcc\PhpDatatypes\Composite\Arrays;

class FloatArray {
    private array $value;

    public function __construct(array $value) {
        foreach ($value as $item) {
            if (!is_float($item)) {
                throw new \InvalidArgumentException("All elements must be floats.");
            }
        }
        $this->value = $value;
    }

    public function getValue(): array {
        return $this->value;
    }
}
