<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use Nejcc\PhpDatatypes\Floats\Float128;
use PHPUnit\Framework\TestCase;

final class Float128Test extends TestCase
{
    public function testSetAndGetValue(): void
    {
        $float = new Float128(1.23456789e4000); // Normal range
        $this->assertEquals(1.23456789e4000, $float->getValue());
    }

//    public function testOutOfRangeException(): void
//    {
//        $this->expectException(\OutOfRangeException::class);
//        new Float128(1.2e4933); // This will likely be treated as INF in PHP, triggering the exception
//    }
}
