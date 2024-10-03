<?php

namespace Nejcc\PhpDatatypes\Composite\Union;

use InvalidArgumentException;

final class Union
{
    private mixed $value;
    private array $allowedTypes;

    public function __construct(array $allowedTypes)
    {
        $this->allowedTypes = $allowedTypes;
    }

    // Set a value of one of the allowed types
    public function setValue(mixed $value): void
    {
        $this->validateType($value);
        $this->value = $value;
    }

    // Get the value
    public function getValue(): mixed
    {
        return $this->value;
    }

    // Validate that the value matches one of the allowed types
    private function validateType(mixed $value): void
    {
        $type = gettype($value);

        if (!in_array($type, $this->allowedTypes, true)) {
            throw new InvalidArgumentException("Invalid type: $type. Allowed types: " . implode(', ', $this->allowedTypes));
        }
    }
}
