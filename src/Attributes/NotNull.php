<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Attributes;

use Attribute;

/**
 * NotNull attribute for ensuring values are not null
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class NotNull
{
    public function __construct() {}
}
