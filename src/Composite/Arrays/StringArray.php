<?php
declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Arrays;

use InvalidArgumentException;

class StringArray
{
    /**
     * The array of string values.
     *
     * @var array
     */
    private array $value;

    /**
     * Create a new StringArray instance.
     *
     * @param array $value
     * @throws InvalidArgumentException
     */
    public function __construct(array $value)
    {
        foreach ($value as $item) {
            if (!is_string($item)) {
                throw new InvalidArgumentException("All elements must be strings.");
            }
        }

        $this->value = $value;
    }

    /**
     * Get the array of string values.
     *
     * @return array
     */
    public function getValue(): array
    {
        return $this->value;
    }

    /**
     * Add a new string to the array.
     *
     * @param string $string
     * @return void
     * @throws InvalidArgumentException
     */
    public function add(string $string): void
    {
        $this->value[] = $string;
    }

    /**
     * Remove a string from the array.
     *
     * @param string $string
     * @return bool True if the string was found and removed, false otherwise.
     */
    public function remove(string $string): bool
    {
        $index = array_search($string, $this->value, true);

        if ($index !== false) {
            unset($this->value[$index]);
            $this->value = array_values($this->value); // Re-index array
            return true;
        }

        return false;
    }

    /**
     * Check if a string exists in the array.
     *
     * @param string $string
     * @return bool
     */
    public function contains(string $string): bool
    {
        return in_array($string, $this->value, true);
    }

    /**
     * Get the count of strings in the array.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->value);
    }

    /**
     * Get the array as a comma-separated string.
     *
     * @return string
     */
    public function toString(): string
    {
        return implode(', ', $this->value);
    }

    /**
     * Clear the array.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->value = [];
    }
}
