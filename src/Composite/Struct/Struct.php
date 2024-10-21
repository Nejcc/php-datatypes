<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct;

use InvalidArgumentException;

final class Struct
{
    /**

     * @var string
     */
    public string $name;
    /**
     * The array that stores field definitions and their values.
     *
     * @var array<string, array{type: string, value: mixed}>
     */
    private array $fields;

    /**
     * Struct constructor.
     *
     * Initializes the struct with the provided fields and types.
     *
     * @param array<string, string> $fields Array of field names and their expected types.
     */
    public function __construct(array $fields)
    {
        $this->fields = [];
        foreach ($fields as $name => $type) {
            $this->addField($name, $type);
        }
    }

    /**

     * Add a new field to the struct.
     *
     * Adds a field to the struct with its specified type and initializes it with a null value.
     *
     * @param string $name The name of the field.
     * @param string $type The expected type of the field.
     * @return void
     */
    private function addField(string $name, string $type): void
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
     * Set the value of a field, ensuring it matches the expected type.
     *
     * Validates that the provided value matches the expected type of the field.
     *
     * @param string $name The field name.
     * @param mixed $value The value to set.
     * @return void
     *
     * @throws InvalidArgumentException if the field doesn't exist or the value type doesn't match.
     */
    public function set(string $name, mixed $value): void
    {
        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException("Field '$name' does not exist in the struct.");
        }

        $expectedType = $this->fields[$name]['type'];
        $actualType = get_debug_type($value);

        // Handle nullable types (e.g., "?string")
        if ($this->isNullable($expectedType) && $value === null) {
            $this->fields[$name]['value'] = $value;
            return;
        }

        $baseType = $this->stripNullable($expectedType);

        // Strict type check with class inheritance support
        if ($actualType !== $baseType && !is_subclass_of($value, $baseType)) {
            throw new InvalidArgumentException("Field '$name' expects type '$expectedType', but got '$actualType'.");
        }

        $this->fields[$name]['value'] = $value;
    }

    /**
     * Get the value of a field.
     *
     * Retrieves the value of the field, throwing an exception if the field doesn't exist.
     *
     * @param string $name The field name.
     * @return mixed The field value.
     *
     * @throws InvalidArgumentException if the field doesn't exist.
     */
    public function get(string $name): mixed
    {
        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException("Field '$name' does not exist in the struct.");
        }

        return $this->fields[$name]['value'];
    }

    /**

     * Get all fields in the struct.
     *
     * Returns the entire set of fields in the struct along with their types and values.
     *
     * @return array<string, array{type: string, value: mixed}> The fields with their respective types and values.

     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Check if the type is nullable (e.g., `?string`).
     *
     * Determines if the field type allows null values.
     *
     * @param string $type The field type.
     * @return bool True if the type is nullable, false otherwise.
     */
    private function isNullable(string $type): bool
    {
        return str_starts_with($type, '?');
    }

    /**
     * Strip the nullable symbol (`?`) from a type.
     *
     * Removes the nullable marker from the type to check the base type.
     *
     * @param string $type The field type.
     * @return string The base type.
     */
    private function stripNullable(string $type): string
    {
        return ltrim($type, '?');
    }

    /**
     * Magic method for accessing fields like object properties.
     *
     * This method allows accessing fields as if they were public properties.
     *
     * @param string $name The field name.
     * @return mixed The field value.
     *
     * @throws InvalidArgumentException if the field doesn't exist.
     */
    public function __get(string $name): mixed
    {
        return $this->get($name);
    }

    /**
     * Magic method for setting fields like object properties.
     *
     * This method allows setting fields as if they were public properties.
     *
     * @param string $name The field name.
     * @param mixed $value The field value.
     * @return void
     *
     * @throws InvalidArgumentException if the field doesn't exist or the value type doesn't match.
     */
    public function __set(string $name, mixed $value): void
    {
        $this->set($name, $value);
    }
}
