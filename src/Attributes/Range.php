<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Attributes;

use Attribute;

/**
 * Range attribute for validating numeric values within bounds
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Range
{
    public function __construct(
        public readonly int|float $min,
        public readonly int|float $max,
    ) {}
}
