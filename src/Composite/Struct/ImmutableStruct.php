<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct;

use Nejcc\PhpDatatypes\Interfaces\StructInterface;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\ImmutableException;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;

/**
 * ImmutableStruct - An immutable struct implementation with field validation
 * and nested struct support.
 */
class ImmutableStruct implements StructInterface
{
    /**
     * @var array<string, array{
     *     type: string,
     *     value: mixed,
     *     required: bool,
     *     default: mixed,
     *     rules: ValidationRule[]
     * }> The struct fields
     */
    private array $fields;

    /**
     * @var bool Whether the struct is frozen (immutable)
     */
    private bool $frozen = false;

    /**
     * Create a new ImmutableStruct instance
     *
     * @param array<string, array{
     *     type: string,
     *     required?: bool,
     *     default?: mixed,
     *     rules?: ValidationRule[]
     * }> $fieldDefinitions Field definitions
     * @param array<string, mixed> $initialValues Initial values for fields
     * @throws InvalidArgumentException If field definitions are invalid or initial values don't match
     * @throws ValidationException If validation rules fail
     */
    public function __construct(array $fieldDefinitions, array $initialValues = [])
    {
        $this->fields = [];
        $this->initializeFields($fieldDefinitions);
        $this->setInitialValues($initialValues);
        $this->frozen = true;
    }

    /**
     * Initialize the struct fields from definitions
     *
     * @param array<string, array{
     *     type: string,
     *     required?: bool,
     *     default?: mixed,
     *     rules?: ValidationRule[]
     * }> $fieldDefinitions
     * @throws InvalidArgumentException If field definitions are invalid
     */
    private function initializeFields(array $fieldDefinitions): void
    {
        foreach ($fieldDefinitions as $name => $definition) {
            if (!isset($definition['type'])) {
                throw new InvalidArgumentException("Field '$name' must have a type definition");
            }

            $this->fields[$name] = [
                'type' => $definition['type'],
                'value' => $definition['default'] ?? null,
                'required' => $definition['required'] ?? false,
                'default' => $definition['default'] ?? null,
                'rules' => $definition['rules'] ?? []
            ];
        }
    }

    /**
     * Set initial values for fields
     *
     * @param array<string, mixed> $initialValues
     * @throws InvalidArgumentException If initial values don't match field definitions
     * @throws ValidationException If validation rules fail
     */
    private function setInitialValues(array $initialValues): void
    {
        foreach ($initialValues as $name => $value) {
            if (!isset($this->fields[$name])) {
                throw new InvalidArgumentException("Field '$name' is not defined in the struct");
            }
            $this->set($name, $value);
        }

        // Validate required fields
        foreach ($this->fields as $name => $field) {
            if ($field['required'] && $field['value'] === null) {
                throw new InvalidArgumentException("Required field '$name' has no value");
            }
        }
    }

    /**
     * Create a new struct with updated values
     *
     * @param array<string, mixed> $values New values to set
     * @return self A new struct instance with the updated values
     * @throws InvalidArgumentException If values don't match field definitions
     * @throws ValidationException If validation rules fail
     */
    public function with(array $values): self
    {
        $newFields = [];
        foreach ($this->fields as $name => $field) {
            $newFields[$name] = [
                'type' => $field['type'],
                'required' => $field['required'],
                'default' => $field['default'],
                'rules' => $field['rules']
            ];
        }

        $newStruct = new self($newFields, $values);
        return $newStruct;
    }

    /**
     * Get a new struct with a single field updated
     *
     * @param string $name Field name
     * @param mixed $value New value
     * @return self A new struct instance with the updated field
     * @throws InvalidArgumentException If the field doesn't exist or value doesn't match type
     * @throws ValidationException If validation rules fail
     */
    public function withField(string $name, mixed $value): self
    {
        return $this->with([$name => $value]);
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $name, mixed $value): void
    {
        if ($this->frozen) {
            throw new ImmutableException("Cannot modify a frozen struct");
        }

        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException("Field '$name' does not exist in the struct");
        }

        $this->validateValue($name, $value);
        $this->fields[$name]['value'] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $name): mixed
    {
        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException("Field '$name' does not exist in the struct");
        }

        return $this->fields[$name]['value'];
    }

    /**
     * {@inheritDoc}
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Get the type of a field
     *
     * @param string $name Field name
     * @return string The field type
     * @throws InvalidArgumentException If the field doesn't exist
     */
    public function getFieldType(string $name): string
    {
        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException("Field '$name' does not exist in the struct");
        }

        return $this->fields[$name]['type'];
    }

    /**
     * Check if a field is required
     *
     * @param string $name Field name
     * @return bool True if the field is required
     * @throws InvalidArgumentException If the field doesn't exist
     */
    public function isFieldRequired(string $name): bool
    {
        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException("Field '$name' does not exist in the struct");
        }

        return $this->fields[$name]['required'];
    }

    /**
     * Get the validation rules for a field
     *
     * @param string $name Field name
     * @return ValidationRule[] The field's validation rules
     * @throws InvalidArgumentException If the field doesn't exist
     */
    public function getFieldRules(string $name): array
    {
        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException("Field '$name' does not exist in the struct");
        }

        return $this->fields[$name]['rules'];
    }

    /**
     * Validate a value against a field's type and rules
     *
     * @param string $name Field name
     * @param mixed $value Value to validate
     * @throws InvalidArgumentException If the value doesn't match the field type
     * @throws ValidationException If validation rules fail
     */
    private function validateValue(string $name, mixed $value): void
    {
        $type = $this->fields[$name]['type'];
        $actualType = get_debug_type($value);

        // Handle nullable types
        if ($this->isNullable($type) && $value === null) {
            return;
        }

        $baseType = $this->stripNullable($type);

        // Handle nested structs
        if (is_subclass_of($baseType, StructInterface::class)) {
            if (!($value instanceof $baseType)) {
                throw new InvalidArgumentException(
                    "Field '$name' expects type '$type', but got '$actualType'"
                );
            }
            return;
        }

        // Handle primitive types
        if ($actualType !== $baseType && !is_subclass_of($value, $baseType)) {
            throw new InvalidArgumentException(
                "Field '$name' expects type '$type', but got '$actualType'"
            );
        }

        // Apply validation rules
        foreach ($this->fields[$name]['rules'] as $rule) {
            $rule->validate($value, $name);
        }
    }

    /**
     * Check if a type is nullable
     *
     * @param string $type Type to check
     * @return bool True if the type is nullable
     */
    private function isNullable(string $type): bool
    {
        return str_starts_with($type, '?');
    }

    /**
     * Strip nullable prefix from a type
     *
     * @param string $type Type to strip
     * @return string Type without nullable prefix
     */
    private function stripNullable(string $type): string
    {
        return ltrim($type, '?');
    }

    /**
     * Convert the struct to an array
     *
     * @return array<string, mixed> The struct data
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this->fields as $name => $field) {
            $value = $field['value'];
            if ($value instanceof StructInterface) {
                $result[$name] = $value->toArray();
            } else {
                $result[$name] = $value;
            }
        }
        return $result;
    }

    /**
     * String representation of the struct
     *
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->toArray());
    }
} 