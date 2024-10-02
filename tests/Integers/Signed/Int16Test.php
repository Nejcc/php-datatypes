<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests\Integers\Signed;

use Nejcc\PhpDatatypes\Integers\Signed\Int16;
use Nejcc\PhpDatatypes\Integers\IntegerInterface;
use PHPUnit\Framework\TestCase;

class Int16Test extends TestCase
{
    public function testValidValueInitialization()
    {
        $int16 = new Int16(32767);
        $this->assertSame(32767, $int16->getValue());
    }

    public function testInvalidValueInitialization()
    {
        $this->expectException(\OutOfRangeException::class);
        new Int16(32768);
    }

    public function testAdditionWithinBounds()
    {
        $int16a = new Int16(20000);
        $int16b = new Int16(10000);
        $int16c = $int16a->add($int16b);
        $this->assertSame(30000, $int16c->getValue());
    }

    public function testAdditionOverflow()
    {
        $this->expectException(\OverflowException::class);
        $int16a = new Int16(30000);
        $int16b = new Int16(10000);
        $int16a->add($int16b);
    }

    public function testSubtractionWithinBounds()
    {
        $int16a = new Int16(-20000);
        $int16b = new Int16(-10000);
        $int16c = $int16a->subtract($int16b);
        $this->assertSame(-10000, $int16c->getValue());
    }

    public function testSubtractionUnderflow()
    {
        $this->expectException(\UnderflowException::class);
        $int16a = new Int16(-30000);
        $int16b = new Int16(10000);
        $int16a->subtract($int16b);
    }

    // Add more tests for multiplication, division, modulus, equality, and comparison
}
