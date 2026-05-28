<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Union;

use InvalidArgumentException;

final class Union
{
    /**
     * The current value of the union.
     *
     * @var mixed
     */
    private mixed $value;

    /**
     * The allowed types for this union.
     *
     * @var array
     */
    private array $allowedTypes;

    /**
     * A mapping of PHP shorthand types to their gettype() equivalents.
     *
     * @var array
     */
    private static array $typeMap = [
        'int' => 'integer',
        'float' => 'double',
        'bool' => 'boolean',
    ];

    /**
     * Create a new Union instance with allowed types.
     *
     * @param array $allowedTypes
     *
     * @return void
     */
    public function __construct(array $allowedTypes)
    {
        $this->allowedTypes = $allowedTypes;
    }

    /**
     * Set the value of the union, validating the type.
     *
     * @param mixed $value
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function setValue(mixed $value): void
    {
        $this->validateType($value);
        $this->value = $value;
    }

    /**
     * Get the current value of the union.
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Determine if the current value is of a specific type.
     *
     * @param string $type
     *
     * @return bool
     */
    public function isType(string $type): bool
    {
        $actualType = gettype($this->value);

        // Map to shorthand if applicable
        $shorthandType = array_search($actualType, self::$typeMap, true);
        $actualType = $shorthandType ?: $actualType;

        return $actualType === $type || $this->value instanceof $type;
    }

    /**
     * Add a new type to the allowed types of the union.
     *
     * @param string $type
     *
     * @return void
     */
    public function addAllowedType(string $type): void
    {
        if (!in_array($type, $this->allowedTypes, true)) {
            $this->allowedTypes[] = $type;
        }
    }

    /**
     * Validate the type of the value against allowed types.
     *
     * @param mixed $value
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    private function validateType(mixed $value): void
    {
        $type = gettype($value);

        // If the type is in the type map, convert to the shorthand notation
        $shorthandType = array_search($type, self::$typeMap, true);
        if ($shorthandType) {
            $type = $shorthandType;
        }

        // If it's a class, validate using 'instanceof' for better OOP support.
        foreach ($this->allowedTypes as $allowedType) {
            if (class_exists($allowedType) && $value instanceof $allowedType) {
                return;
            }
        }

        // Check against the allowed types array.
        if (!in_array($type, $this->allowedTypes, true)) {
            throw new InvalidArgumentException(
                "Invalid type: $type. Allowed types: " . implode(', ', $this->allowedTypes)
            );
        }
    }
}
