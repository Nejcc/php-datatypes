<?php
declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Arrays;

use Countable;
use ArrayAccess;
use IteratorAggregate;
use Traversable;
use Nejcc\PhpDatatypes\Exceptions\InvalidByteException;

readonly class ByteSlice implements Countable, ArrayAccess, IteratorAggregate
{
    /**
     * @var array<int> The byte values (0-255).
     */
    private array $value;

    /**
     * Constructor for ByteSlice.
     *
     * @param array<int> $value The array of byte values.
     * @throws InvalidByteException If any value is not a valid byte.
     */
    public function __construct(array $value)
    {
        $this->validateBytes($value);
        $this->value = $value;
    }

    /**
     * Validate that all elements are valid bytes (0-255).
     *
     * @param array $array The array to validate.
     * @throws InvalidByteException If any element is not a valid byte.
     * @return void
     */
    private function validateBytes(array $array): void
    {
        foreach ($array as $item) {
            if (!is_int($item) || $item < 0 || $item > 255) {
                throw new InvalidByteException("All elements must be valid bytes (0-255). Invalid value: " . $item);
            }
        }
    }

    /**
     * Get the array of byte values.
     *
     * @return array<int> The byte array.
     */
    public function getValue(): array
    {
        return $this->value;
    }

    /**
     * Get the byte at a specific index.
     *
     * @param int $index The index.
     * @return int|null The byte value or null if index is out of bounds.
     */
    public function getByte(int $index): ?int
    {
        return $this->value[$index] ?? null;
    }

    /**
     * Get the count of bytes in the array.
     *
     * @return int The number of bytes.
     */
    public function count(): int
    {
        return count($this->value);
    }

    /**
     * Convert the byte slice to a hexadecimal string.
     *
     * @return string The hexadecimal representation.
     */
    public function toHex(): string
    {
        return implode('', array_map(fn($byte) => sprintf('%02X', $byte), $this->value));
    }

    /**
     * Slice a portion of the byte array.
     *
     * @param int $offset The start offset.
     * @param int|null $length The length of the slice.
     * @return ByteSlice The sliced byte array.
     * @throws InvalidByteException
     */
    public function slice(int $offset, ?int $length = null): self
    {
        return new self(array_slice($this->value, $offset, $length));
    }

    /**
     * Merge the current byte array with another byte array.
     *
     * @param ByteSlice $other The other byte array to merge.
     * @return ByteSlice A new ByteSlice instance containing the merged bytes.
     * @throws InvalidByteException
     */
    public function merge(ByteSlice $other): self
    {
        return new self(array_merge($this->value, $other->getValue()));
    }

    /**
     * ArrayAccess: Check if a byte exists at the given offset.
     *
     * @param int $offset The array offset.
     * @return bool True if offset exists, false otherwise.
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->value[$offset]);
    }

    /**
     * ArrayAccess: Get the byte at the given offset.
     *
     * @param int $offset The array offset.
     * @return mixed The byte value at the given offset.
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->value[$offset] ?? null;
    }

    /**
     * ArrayAccess: Prevent modification by throwing an exception.
     *
     * @param int $offset The array offset.
     * @param mixed $value The value to set (not allowed).
     * @throws InvalidByteException Always thrown since ByteSlice is immutable.
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new InvalidByteException("Cannot modify an immutable ByteSlice.");
    }

    /**
     * ArrayAccess: Prevent unsetting by throwing an exception.
     *
     * @param int $offset The array offset.
     * @throws InvalidByteException Always thrown since ByteSlice is immutable.
     */
    public function offsetUnset(mixed $offset): void
    {
        throw new InvalidByteException("Cannot unset a value in an immutable ByteSlice.");
    }

    /**
     * Get an iterator for the byte array.
     *
     * @return Traversable An iterator for the byte array.
     */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->value);
    }
}
