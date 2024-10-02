<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use Nejcc\PhpDatatypes\Floats\Float16;
use PHPUnit\Framework\TestCase;

final class Float16Test extends TestCase
{
    public function testSetAndGetValue(): void
    {
        $float = new Float16(12345.67);
        $this->assertEquals(12345.67, $float->getValue());
    }

    public function testOutOfRangeException(): void
    {
        $this->expectException(\OutOfRangeException::class);
        new Float16(70000.0); // Value out of Float16 range
    }
}
