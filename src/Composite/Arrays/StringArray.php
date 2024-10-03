<?php

namespace Nejcc\PhpDatatypes\Composite\Arrays;

class StringArray {
    private array $value;

    public function __construct(array $value) {
        foreach ($value as $item) {
            if (!is_string($item)) {
                throw new \InvalidArgumentException("All elements must be strings.");
            }
        }
        $this->value = $value;
    }

    public function getValue(): array {
        return $this->value;
    }
}
