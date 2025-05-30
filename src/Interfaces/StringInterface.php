<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Interfaces;

/**
 * Interface for string operations.
 *
 * @package Nejcc\PhpDatatypes\Interfaces
 */
interface StringInterface
{
    /**
     * Get the string value.
     *
     * @return string
     */
    public function getValue(): string;

    /**
     * Compare two strings.
     *
     * @param StringInterface $other
     *
     * @return int
     */
    public function compare(StringInterface $other): int;

    /**
     * Append another string.
     *
     * @param StringInterface $other
     *
     * @return static
     */
    public function append(StringInterface $other): static;

    /**
     * Get a substring.
     *
     * @param int $start
     * @param int|null $length
     *
     * @return static
     */
    public function substring(int $start, ?int $length = null): static;

    /**
     * Check if string contains another string.
     *
     * @param StringInterface $needle
     *
     * @return bool
     */
    public function contains(StringInterface $needle): bool;

    /**
     * Get string length.
     *
     * @return int
     */
    public function length(): int;
}
