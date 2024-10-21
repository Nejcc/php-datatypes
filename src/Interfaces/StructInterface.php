<?php

namespace Nejcc\PhpDatatypes\Interfaces;

interface StructInterface
{
    /**
     * Set the value of a field.
     *
     * @param string $name The field name.
     * @param mixed $value The value to set.
     * @return void
     */
    public function set(string $name, mixed $value): void;

    /**
     * Get the value of a field.
     *
     * @param string $name The field name.
     * @return mixed The field value.
     */
    public function get(string $name): mixed;

    /**
     * Get all fields in the struct.
     *
     * @return array<string, array{type: string, value: mixed}> The fields with their respective types and values.
     */
    public function getFields(): array;
}
