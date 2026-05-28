<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar;

use Nejcc\PhpDatatypes\Abstract\BooleanAbstraction;

/**
 * Represents a boolean value with type safety and additional operations.
 *
 * This class provides a type-safe way to work with boolean values, including
 * logical operations (AND, OR, XOR, NOT) and various conversion methods.
 *
 * @example
 * ```php
 * $bool = new Boolean(true);
 * $result = $bool->and(new Boolean(false)); // Returns false
 * $string = (string) $bool; // Returns "true"
 * ```
 */
final class Boolean extends BooleanAbstraction
{
}
