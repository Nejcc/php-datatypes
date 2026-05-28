<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests\Integers\Unsigned;

use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt16;
use PHPUnit\Framework\TestCase;

final class UInt16Test extends TestCase
{
    public function testValidInitialization()
    {
        $uint16 = new UInt16(65535);
        $this->assertSame(65535, $uint16->getValue());
    }

    public function testInvalidInitialization()
    {
        $this->expectException(\OutOfRangeException::class);
        new UInt16(65536);
    }

    public function testAdditionWithinBounds()
    {
        $uint16a = new UInt16(50000);
        $uint16b = new UInt16(15535);
        $uint16c = $uint16a->add($uint16b);
        $this->assertSame(65535, $uint16c->getValue());
    }

    public function testAdditionOverflow()
    {
        $this->expectException(\OverflowException::class);
        $uint16a = new UInt16(50000);
        $uint16b = new UInt16(20000);
        $uint16a->add($uint16b);
    }

    public function testSubtractionWithinBounds()
    {
        $uint16a = new UInt16(50000);
        $uint16b = new UInt16(10000);
        $uint16c = $uint16a->subtract($uint16b);
        $this->assertSame(40000, $uint16c->getValue());
    }

    public function testSubtractionUnderflow()
    {
        $this->expectException(\UnderflowException::class);
        $uint16a = new UInt16(10000);
        $uint16b = new UInt16(20000);
        $uint16a->subtract($uint16b);
    }

    public function testMultiplicationWithinBounds()
    {
        $uint16a = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt16(3000);
        $uint16b = new UInt16(20);
        $uint16c = $uint16a->multiply($uint16b);
        $this->assertSame(60000, $uint16c->getValue());
    }

    public function testMultiplicationOverflow()
    {
        $this->expectException(\OverflowException::class);
        $uint16a = new UInt16(4000);
        $uint16b = new UInt16(20);
        $uint16a->multiply($uint16b);
    }

    public function testDivisionWithinBounds()
    {
        $uint16a = new UInt16(50000);
        $uint16b = new UInt16(10);
        $uint16c = $uint16a->divide($uint16b);
        $this->assertSame(5000, $uint16c->getValue());
    }

    public function testDivisionByZero()
    {
        $this->expectException(\DivisionByZeroError::class);
        $uint16a = new UInt16(50000);
        $uint16b = new UInt16(0);
        $uint16a->divide($uint16b);
    }

    public function testModulusWithinBounds()
    {
        $uint16a = new UInt16(50000);
        $uint16b = new UInt16(12000);
        $uint16c = $uint16a->mod($uint16b);
        $this->assertSame(2000, $uint16c->getValue());
    }

    public function testEquality()
    {
        $uint16a = new UInt16(30000);
        $uint16b = new UInt16(30000);
        $this->assertTrue($uint16a->equals($uint16b));
    }

    public function testInequality()
    {
        $uint16a = new UInt16(30000);
        $uint16b = new UInt16(40000);
        $this->assertFalse($uint16a->equals($uint16b));
    }

    public function testComparison()
    {
        $uint16a = new UInt16(30000);
        $uint16b = new UInt16(40000);
        $this->assertSame(-1, $uint16a->compare($uint16b));
        $this->assertSame(1, $uint16b->compare($uint16a));
        $uint16c = new UInt16(30000);
        $this->assertSame(0, $uint16a->compare($uint16c));
    }
}
