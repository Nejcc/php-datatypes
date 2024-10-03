<?php

namespace Nejcc\PhpDatatypes\Scalar;

class Char {
    private string $value;

    public function __construct(string $value) {
        if (strlen($value) !== 1) {
            throw new \InvalidArgumentException("Char must be a single character.");
        }
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }
}
