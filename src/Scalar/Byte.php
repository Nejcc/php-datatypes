<?php

namespace Nejcc\PhpDatatypes\Scalar;

class Byte {
    private int $value;

    public function __construct(int $value) {
        if ($value < 0 || $value > 255) {
            throw new \InvalidArgumentException("Byte value must be between 0 and 255.");
        }
        $this->value = $value;
    }

    public function getValue(): int {
        return $this->value;
    }
}
