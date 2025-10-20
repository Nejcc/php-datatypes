<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Attributes;

use Attribute;

/**
 * Url attribute for validating URLs
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Url
{
    public function __construct() {}
}
