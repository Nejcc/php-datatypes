<?php

namespace Nejcc\PhpDatatypes\Abstract;

use InvalidArgumentException;
use Nejcc\PhpDatatypes\Interfaces\StructInterface;

abstract class BaseStruct implements StructInterface
{
    /**
     * @var array<string, array{type: string, value: mixed}>
     */
    protected array $fields = [];

    /**
     * Add a new field to the struct.
     *
     * @param string $name The name of the field.
     * @param string $type The expected type of the field.
     * @return void
     */
    protected function addField(string $name, string $type): void
    {
        if (isset($this->fields[$name])) {
            throw new InvalidArgumentException("Field '$name' already exists in the struct.");
        }

        $this->fields[$name] = [
            'type' => $type,
            'value' => null
        ];
    }

    /**
     * Check if the type is nullable (e.g., `?string`).
     *
     * @param string $type The field type.
     * @return bool True if the type is nullable, false otherwise.
     */
    protected function isNullable(string $type): bool
    {
        return str_starts_with($type, '?');
    }

    /**
     * Strip the nullable symbol (`?`) from a type.
     *
     * @param string $type The field type.
     * @return string The base type.
     */
    protected function stripNullable(string $type): string
    {
        return ltrim($type, '?');
    }
}
