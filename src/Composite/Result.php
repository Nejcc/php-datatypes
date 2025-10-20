<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;

/**
 * Result type for handling success/error states in a type-safe way.
 * 
 * This is an algebraic data type that represents either Ok(value) or Err(error).
 * It provides a safe way to handle operations that can fail without throwing exceptions.
 * 
 * @template T The success value type
 * @template E The error type
 */
final class Result
{
    /**
     * @var T|E The wrapped value or error
     */
    private mixed $value;

    /**
     * @var bool Whether this Result is Ok (true) or Err (false)
     */
    private bool $isOk;

    /**
     * Private constructor to enforce use of factory methods
     * 
     * @param mixed $value
     * @param bool $isOk
     */
    private function __construct(mixed $value, bool $isOk)
    {
        $this->value = $value;
        $this->isOk = $isOk;
    }

    /**
     * Create an Ok Result with a value
     * 
     * @param T $value
     * @return self<T, E>
     */
    public static function ok(mixed $value): self
    {
        return new self($value, true);
    }

    /**
     * Create an Err Result with an error
     * 
     * @param E $error
     * @return self<T, E>
     */
    public static function err(mixed $error): self
    {
        return new self($error, false);
    }

    /**
     * Create a Result from a callable that might throw
     * 
     * @param callable(): T $callable
     * @return self<T, \Throwable>
     */
    public static function try(callable $callable): self
    {
        try {
            return self::ok($callable());
        } catch (\Throwable $e) {
            return self::err($e);
        }
    }

    /**
     * Check if this Result is Ok
     * 
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->isOk;
    }

    /**
     * Check if this Result is Err
     * 
     * @return bool
     */
    public function isErr(): bool
    {
        return !$this->isOk;
    }

    /**
     * Get the value if Ok, throw exception if Err
     * 
     * @return T
     * @throws InvalidArgumentException
     */
    public function unwrap(): mixed
    {
        if ($this->isErr()) {
            throw new InvalidArgumentException('Cannot unwrap Err Result');
        }
        return $this->value;
    }

    /**
     * Get the error if Err, throw exception if Ok
     * 
     * @return E
     * @throws InvalidArgumentException
     */
    public function unwrapErr(): mixed
    {
        if ($this->isOk()) {
            throw new InvalidArgumentException('Cannot unwrap error from Ok Result');
        }
        return $this->value;
    }

    /**
     * Get the value if Ok, return default if Err
     * 
     * @param T $default
     * @return T
     */
    public function unwrapOr(mixed $default): mixed
    {
        return $this->isOk() ? $this->value : $default;
    }

    /**
     * Get the value if Ok, return result of callback if Err
     * 
     * @param callable(E): T $callback
     * @return T
     */
    public function unwrapOrElse(callable $callback): mixed
    {
        return $this->isOk() ? $this->value : $callback($this->value);
    }

    /**
     * Transform the value if Ok, return Err if Err
     * 
     * @template U
     * @param callable(T): U $callback
     * @return self<U, E>
     */
    public function map(callable $callback): self
    {
        return $this->isOk() 
            ? self::ok($callback($this->value))
            : self::err($this->value);
    }

    /**
     * Transform the error if Err, return Ok if Ok
     * 
     * @template F
     * @param callable(E): F $callback
     * @return self<T, F>
     */
    public function mapErr(callable $callback): self
    {
        return $this->isErr() 
            ? self::err($callback($this->value))
            : self::ok($this->value);
    }

    /**
     * Transform the value if Ok, return default if Err
     * 
     * @template U
     * @param callable(T): U $callback
     * @param U $default
     * @return U
     */
    public function mapOr(callable $callback, mixed $default): mixed
    {
        return $this->isOk() ? $callback($this->value) : $default;
    }

    /**
     * Transform the value if Ok, return result of callback if Err
     * 
     * @template U
     * @param callable(T): U $callback
     * @param callable(E): U $defaultCallback
     * @return U
     */
    public function mapOrElse(callable $callback, callable $defaultCallback): mixed
    {
        return $this->isOk() ? $callback($this->value) : $defaultCallback($this->value);
    }

    /**
     * Chain another Result if this is Ok
     * 
     * @template U
     * @param callable(T): self<U, E> $callback
     * @return self<U, E>
     */
    public function andThen(callable $callback): self
    {
        return $this->isOk() ? $callback($this->value) : self::err($this->value);
    }

    /**
     * Return this Result if Ok, return other if Err
     * 
     * @param self<T, E> $other
     * @return self<T, E>
     */
    public function or(self $other): self
    {
        return $this->isOk() ? $this : $other;
    }

    /**
     * Return this Result if Ok, return result of callback if Err
     * 
     * @param callable(E): self<T, E> $callback
     * @return self<T, E>
     */
    public function orElse(callable $callback): self
    {
        return $this->isOk() ? $this : $callback($this->value);
    }

    /**
     * Convert to Option: Some(value) if Ok, None if Err
     * 
     * @return \Nejcc\PhpDatatypes\Composite\Option<T>
     */
    public function toOption(): \Nejcc\PhpDatatypes\Composite\Option
    {
        return $this->isOk() 
            ? \Nejcc\PhpDatatypes\Composite\Option::some($this->value)
            : \Nejcc\PhpDatatypes\Composite\Option::none();
    }

    /**
     * Convert to Option: Some(error) if Err, None if Ok
     * 
     * @return \Nejcc\PhpDatatypes\Composite\Option<E>
     */
    public function toErrorOption(): \Nejcc\PhpDatatypes\Composite\Option
    {
        return $this->isErr() 
            ? \Nejcc\PhpDatatypes\Composite\Option::some($this->value)
            : \Nejcc\PhpDatatypes\Composite\Option::none();
    }

    /**
     * Check if this Result equals another Result
     * 
     * @param self<T, E> $other
     * @return bool
     */
    public function equals(self $other): bool
    {
        if ($this->isOk() !== $other->isOk()) {
            return false;
        }
        
        return $this->value === $other->value;
    }

    /**
     * Convert to array representation
     * 
     * @return array{isOk: bool, value: T|E}
     */
    public function toArray(): array
    {
        return [
            'isOk' => $this->isOk,
            'value' => $this->value
        ];
    }

    /**
     * Create from array representation
     * 
     * @param array{isOk: bool, value: T|E} $data
     * @return self<T, E>
     */
    public static function fromArray(array $data): self
    {
        if (!isset($data['isOk']) || !is_bool($data['isOk'])) {
            throw new InvalidArgumentException('Invalid Result array format');
        }
        
        return new self($data['value'] ?? null, $data['isOk']);
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
     * @return self<T, E>
     * @throws InvalidArgumentException
     */
    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);
        if (!is_array($data)) {
            throw new InvalidArgumentException('Invalid JSON format for Result');
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
        return $this->isOk() 
            ? sprintf('Ok(%s)', var_export($this->value, true))
            : sprintf('Err(%s)', var_export($this->value, true));
    }
}
