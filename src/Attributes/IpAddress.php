<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Attributes;

use Attribute;

/**
 * IpAddress attribute for validating IP addresses
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class IpAddress
{
    public function __construct() {}
}
