<?php

namespace Nejcc\PhpDatatypes\Composite\Struct;

use InvalidArgumentException;
use Nejcc\PhpDatatypes\Abstract\BaseStruct;

final class Struct extends BaseStruct
{
    /**
     * Struct constructor.
     *
     * @param array<string, string> $fields Array of field names and their expected types.
     */
    public function __construct(array $fields)
    {
        foreach ($fields as $name => $type) {
            $this->addField($name, $type);
        }
    }

    /**
     * {@inheritDoc}
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

        if ($actualType !== $baseType && !is_subclass_of($value, $baseType)) {
            throw new InvalidArgumentException("Field '$name' expects type '$expectedType', but got '$actualType'.");
        }

        $this->fields[$name]['value'] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $name): mixed
    {
        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException("Field '$name' does not exist in the struct.");
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
     * Magic method for accessing fields like object properties.
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
