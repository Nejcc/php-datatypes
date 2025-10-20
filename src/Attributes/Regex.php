<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Attributes;

use Attribute;

/**
 * Regex attribute for validating strings against regular expressions
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Regex
{
    public function __construct(
        public readonly string $pattern,
    ) {}
}
