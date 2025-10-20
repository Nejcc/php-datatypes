<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Attributes;

use Attribute;

/**
 * Length attribute for validating string length
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Length
{
    public function __construct(
        public readonly ?int $min = null,
        public readonly ?int $max = null,
    ) {}
}
