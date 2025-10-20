<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * Option type for handling nullable values in a type-safe way.
 * 
 * This is an algebraic data type that represents either Some(value) or None.
 * It provides a safe way to handle nullable values without null pointer exceptions.
 * 
 * @template T
 */
final class Option
{
    /**
     * @var T|null The wrapped value, null if None
     */
    private mixed $value;

    /**
     * @var bool Whether this Option contains a value
     */
    private bool $isSome;

    /**
     * Private constructor to enforce use of factory methods
     * 
     * @param mixed $value
     * @param bool $isSome
     */
    private function __construct(mixed $value, bool $isSome)
    {
        $this->value = $value;
        $this->isSome = $isSome;
    }

    /**
     * Create a Some Option with a value
     * 
     * @param T $value
     * @return self<T>
     */
    public static function some(mixed $value): self
    {
        return new self($value, true);
    }

    /**
     * Create a None Option
     * 
     * @return self<T>
     */
    public static function none(): self
    {
        return new self(null, false);
    }

    /**
     * Create an Option from a nullable value
     * 
     * @param T|null $value
     * @return self<T>
     */
    public static function fromNullable(mixed $value): self
    {
        return $value === null ? self::none() : self::some($value);
    }

    /**
     * Check if this Option contains a value
     * 
     * @return bool
     */
    public function isSome(): bool
    {
        return $this->isSome;
    }

    /**
     * Check if this Option is empty
     * 
     * @return bool
     */
    public function isNone(): bool
    {
        return !$this->isSome;
    }

    /**
     * Get the value if Some, throw exception if None
     * 
     * @return T
     * @throws InvalidArgumentException
     */
    public function unwrap(): mixed
    {
        if ($this->isNone()) {
            throw new InvalidArgumentException('Cannot unwrap None Option');
        }
        return $this->value;
    }

    /**
     * Get the value if Some, return default if None
     * 
     * @param T $default
     * @return T
     */
    public function unwrapOr(mixed $default): mixed
    {
        return $this->isSome() ? $this->value : $default;
    }

    /**
     * Get the value if Some, return result of callback if None
     * 
     * @param callable(): T $callback
     * @return T
     */
    public function unwrapOrElse(callable $callback): mixed
    {
        return $this->isSome() ? $this->value : $callback();
    }

    /**
     * Transform the value if Some, return None if None
     * 
     * @template U
     * @param callable(T): U $callback
     * @return self<U>
     */
    public function map(callable $callback): self
    {
        return $this->isSome() 
            ? self::some($callback($this->value))
            : self::none();
    }

    /**
     * Transform the value if Some, return default if None
     * 
     * @template U
     * @param callable(T): U $callback
     * @param U $default
     * @return U
     */
    public function mapOr(callable $callback, mixed $default): mixed
    {
        return $this->isSome() ? $callback($this->value) : $default;
    }

    /**
     * Transform the value if Some, return result of callback if None
     * 
     * @template U
     * @param callable(T): U $callback
     * @param callable(): U $defaultCallback
     * @return U
     */
    public function mapOrElse(callable $callback, callable $defaultCallback): mixed
    {
        return $this->isSome() ? $callback($this->value) : $defaultCallback();
    }

    /**
     * Chain another Option if this is Some
     * 
     * @template U
     * @param callable(T): self<U> $callback
     * @return self<U>
     */
    public function andThen(callable $callback): self
    {
        return $this->isSome() ? $callback($this->value) : self::none();
    }

    /**
     * Return this Option if Some, return other if None
     * 
     * @param self<T> $other
     * @return self<T>
     */
    public function or(self $other): self
    {
        return $this->isSome() ? $this : $other;
    }

    /**
     * Return this Option if Some, return result of callback if None
     * 
     * @param callable(): self<T> $callback
     * @return self<T>
     */
    public function orElse(callable $callback): self
    {
        return $this->isSome() ? $this : $callback();
    }

    /**
     * Filter the value if Some based on predicate
     * 
     * @param callable(T): bool $predicate
     * @return self<T>
     */
    public function filter(callable $predicate): self
    {
        return $this->isSome() && $predicate($this->value) ? $this : self::none();
    }

    /**
     * Check if this Option equals another Option
     * 
     * @param self<T> $other
     * @return bool
     */
    public function equals(self $other): bool
    {
        if ($this->isSome() !== $other->isSome()) {
            return false;
        }
        
        if ($this->isNone()) {
            return true;
        }
        
        return $this->value === $other->value;
    }

    /**
     * Convert to array representation
     * 
     * @return array{isSome: bool, value: T|null}
     */
    public function toArray(): array
    {
        return [
            'isSome' => $this->isSome,
            'value' => $this->value
        ];
    }

    /**
     * Create from array representation
     * 
     * @param array{isSome: bool, value: T|null} $data
     * @return self<T>
     */
    public static function fromArray(array $data): self
    {
        if (!isset($data['isSome']) || !is_bool($data['isSome'])) {
            throw new InvalidArgumentException('Invalid Option array format');
        }
        
        return new self($data['value'] ?? null, $data['isSome']);
    }

    /**
     * Convert to JSON string
     * 
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Create from JSON string
     * 
     * @param string $json
     * @return self<T>
     * @throws InvalidArgumentException
     */
    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);
        if (!is_array($data)) {
            throw new InvalidArgumentException('Invalid JSON format for Option');
        }
        
        return self::fromArray($data);
    }

    /**
     * String representation
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->isSome() 
            ? sprintf('Some(%s)', var_export($this->value, true))
            : 'None';
    }
}
