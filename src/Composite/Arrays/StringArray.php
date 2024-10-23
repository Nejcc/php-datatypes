<?php
declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Arrays;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Nejcc\PhpDatatypes\Exceptions\InvalidStringException;
use Traversable;

readonly class StringArray implements ArrayAccess, Countable, IteratorAggregate
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
     * @throws InvalidStringException
     */
    public function __construct(array $value = [])
    {
        $this->validateArray($value);
        $this->value = $value;
    }

    /**
     * Validates that the array consists only of strings.
     *
     * @param array $array
     * @return void
     * @throws InvalidStringException
     */
    private function validateArray(array $array): void
    {
        foreach ($array as $item) {
            if (!is_string($item)) {
                throw new InvalidStringException("All elements must be strings. Invalid value: " . json_encode($item));
            }
        }
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
     * Add multiple strings to the array (returns a new instance).
     *
     * @param string ...$strings
     * @return self New instance with added values.
     * @throws InvalidStringException
     */
    public function add(string ...$strings): self
    {
        $this->validateArray($strings);
        return new self(array_merge($this->value, $strings));
    }

    /**
     * Remove multiple strings from the array (returns a new instance).
     *
     * @param string ...$strings
     * @return self New instance with removed values.
     * @throws InvalidStringException
     */
    public function remove(string ...$strings): self
    {
        $newArray = $this->value;
        foreach ($strings as $string) {
            $index = array_search($string, $newArray, true);
            if ($index !== false) {
                unset($newArray[$index]);
            }
        }
        return new self(array_values($newArray)); // Re-index array
    }

    /**
     * Check if multiple strings exist in the array.
     *
     * @param string ...$strings
     * @return bool True if all strings are found, false otherwise.
     */
    public function contains(string ...$strings): bool
    {
        foreach ($strings as $string) {
            if (!in_array($string, $this->value, true)) {
                return false;
            }
        }
        return true;
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
     * Get the array as a comma-separated string or with custom separator.
     *
     * @param string $separator Separator to use between strings (default: ", ").
     * @return string
     */
    public function toString(string $separator = ', '): string
    {
        return implode($separator, $this->value);
    }

    /**
     * Find strings that start with a specific prefix.
     *
     * @param string $prefix
     * @return array Array of strings that start with the given prefix.
     */
    public function filterByPrefix(string $prefix): array
    {
        return array_values(array_filter($this->value, fn($str) => str_starts_with($str, $prefix)));
    }


    /**
     * Find strings that contain a specific substring.
     *
     * @param string $substring
     * @return array Array of strings that contain the substring.
     */
    public function filterBySubstring(string $substring): array
    {
        return array_values(array_filter($this->value, fn($str) => str_contains($str, $substring)));
    }


    /**
     * Get a string at a specific index.
     *
     * @param int $index
     * @return string|null
     */
    public function get(int $index): ?string
    {
        return $this->value[$index] ?? null;
    }

    /**
     * Convert all strings to uppercase (returns a new instance).
     *
     * @return self
     * @throws InvalidStringException
     */
    public function toUpperCase(): self
    {
        return new self(array_map('strtoupper', $this->value));
    }

    /**
     * Convert all strings to lowercase (returns a new instance).
     *
     * @return self
     * @throws InvalidStringException
     */
    public function toLowerCase(): self
    {
        return new self(array_map('strtolower', $this->value));
    }

    /**
     * Clear the array (returns a new empty instance).
     *
     * @return self
     * @throws InvalidStringException
     */
    public function clear(): self
    {
        return new self([]);
    }

    /**
     * ArrayAccess method to check if an offset exists.
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->value[$offset]);
    }

    /**
     * ArrayAccess method to get an offset.
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->value[$offset] ?? null;
    }

    /**
     * ArrayAccess method to set an offset (immutable, returns a new instance).
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     * @throws InvalidStringException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new InvalidStringException("Cannot modify immutable StringArray.");
    }

    /**
     * ArrayAccess method to unset an offset (immutable, returns a new instance).
     *
     * @param mixed $offset
     * @return void
     * @throws InvalidStringException
     */
    public function offsetUnset(mixed $offset): void
    {
        throw new InvalidStringException("Cannot modify immutable StringArray.");
    }

    /**
     * Returns an iterator for traversing the array.
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->value);
    }
}
