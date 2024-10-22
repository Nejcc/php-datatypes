<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;


use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float64;
use PHPUnit\Framework\TestCase;

final class Float64Test extends TestCase
{
    public function testSetAndGetValue(): void
    {
        $float = new Float64(1.23456789e100);
        $this->assertEquals(1.23456789e100, $float->getValue());
    }

    public function testOutOfRangeException(): void
    {
        $this->expectException(\OutOfRangeException::class);
        new Float64(2.0e308); // Value out of Float64 range
    }
}
