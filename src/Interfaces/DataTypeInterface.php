<?php

namespace Nejcc\PhpDatatypes\Interfaces;

interface DataTypeInterface
{
    /**
     * Get the value of the data type
     *
     * @return mixed
     */
    public function getValue(): mixed;

    /**
     * Set the value of the data type
     *
     * @param mixed $value
     * @return void
     */
    public function setValue(mixed $value): void;

    /**
     * Convert the data type to a string representation
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Check if this data type equals another data type
     *
     * @param DataTypeInterface $other
     * @return bool
     */
    public function equals(DataTypeInterface $other): bool;
} 