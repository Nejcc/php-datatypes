<?php

namespace Nejcc\PhpDatatypes\Composite\Struct;

use InvalidArgumentException;

final class Struct
{
    /**
     * @var array
     */
    private array $fields = [];

    public function __construct(array $fields)
    {
        foreach ($fields as $name => $type) {
            $this->addField($name, $type);
        }
    }

    /**
     * @param string $name
     * @param string $type
     * @return void
     */
    public function addField(string $name, string $type): void
    {
        $this->fields[$name] = [
            'type' => $type,
            'value' => null
        ];
    }


    /**
     * @param string $name
     * @param $value
     * @return void
     */
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


    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        if (!isset($this->fields[$name])) {
            throw new InvalidArgumentException("Field $name does not exist in the struct.");
        }

        return $this->fields[$name]['value'];
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}
