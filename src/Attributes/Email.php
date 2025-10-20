<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Attributes;

use Attribute;

/**
 * Email attribute for validating email addresses
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Email
{
    public function __construct() {}
}
