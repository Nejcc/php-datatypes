<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use Nejcc\PhpDatatypes\Floats\Float8;
use PHPUnit\Framework\TestCase;

final class Float8Test extends TestCase
{
    public function testSetAndGetValue(): void
    {
        $float = new Float8(123.45);
        $this->assertEquals(123.45, $float->getValue());
    }

    public function testOutOfRangeException(): void
    {
        $this->expectException(\OutOfRangeException::class);
        new Float8(250.0); // Value out of Float8 range
    }
}
