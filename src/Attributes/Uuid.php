<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Attributes;

use Attribute;

/**
 * Uuid attribute for validating UUID strings
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Uuid
{
    public function __construct() {}
}
