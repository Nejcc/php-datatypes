<?php

namespace Nejcc\PhpDatatypes\Composite\Struct;

use InvalidArgumentException;

final class Struct
{
    private array $fields = [];

    public function __construct(array $fields)
    {
        foreach ($fields as $name => $type) {
            $this->addField($name, $type);
        }
    }

    // Add a field with a specific type
    public function addField(string $name, string $type): void
    {
        $this->fields[$name] = [
            'type' => $type,
            'value' => null
        ];
    }

    // Set the value of a field, ensuring it matches the type
    public function set(string $name, $value): void
    {
        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException("Field $name does not exist in the struct.");
        }

        $expectedType = $this->fields[$name]['type'];
        $actualType = get_debug_type($value);

        // PHP 8.3 has a more robust `get_debug_type()` that supports more specific types.
        if ($actualType !== $expectedType && !is_subclass_of($actualType, $expectedType)) {
            throw new InvalidArgumentException("Field $name expects type $expectedType, but got $actualType.");
        }

        $this->fields[$name]['value'] = $value;
    }

    // Get the value of a field
    public function get(string $name)
    {
        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException("Field $name does not exist in the struct.");
        }

        return $this->fields[$name]['value'];
    }

    // Get all fields
    public function getFields(): array
    {
        return $this->fields;
    }
}
