<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use Nejcc\PhpDatatypes\Floats\Float32;
use PHPUnit\Framework\TestCase;

final class Float32Test extends TestCase
{
    public function testSetAndGetValue(): void
    {
        $float = new Float32(1.234567e10);
        $this->assertEquals(1.234567e10, $float->getValue());
    }

    public function testOutOfRangeException(): void
    {
        $this->expectException(\OutOfRangeException::class);
        new Float32(4.0e38); // Value out of Float32 range
    }
}
