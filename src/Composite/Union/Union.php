<?php

namespace Nejcc\PhpDatatypes\Composite\Union;

use InvalidArgumentException;

final class Union
{
    /**
     * @var mixed
     */
    private mixed $value;

    /**
     * @var array
     */
    private array $allowedTypes;

    /**
     * @param array $allowedTypes
     */
    public function __construct(array $allowedTypes)
    {
        $this->allowedTypes = $allowedTypes;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setValue(mixed $value): void
    {
        $this->validateType($value);
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return void
     */
    private function validateType(mixed $value): void
    {
        $type = gettype($value);

        if (!in_array($type, $this->allowedTypes, true)) {
            throw new InvalidArgumentException("Invalid type: $type. Allowed types: " . implode(', ', $this->allowedTypes));
        }
    }
}
