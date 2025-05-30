<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests\Integers\Unsigned;

use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;
use PHPUnit\Framework\TestCase;

final class UInt8Test extends TestCase
{
    public function testValidInitialization()
    {
        $uint8 = new UInt8(255);
        $this->assertSame(255, $uint8->getValue());
    }

    public function testInvalidInitialization()
    {
        $this->expectException(\OutOfRangeException::class);
        new UInt8(256);
    }

    public function testAdditionWithinBounds()
    {
        $uint8a = new UInt8(200);
        $uint8b = new UInt8(55);
        $uint8c = $uint8a->add($uint8b);
        $this->assertSame(255, $uint8c->getValue());
    }

    public function testAdditionOverflow()
    {
        $this->expectException(\OverflowException::class);
        $uint8a = new UInt8(200);
        $uint8b = new UInt8(100);
        $uint8a->add($uint8b);
    }

    public function testSubtractionWithinBounds()
    {
        $uint8a = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8(200);
        $uint8b = new UInt8(50);
        $uint8c = $uint8a->subtract($uint8b);
        $this->assertSame(150, $uint8c->getValue());
    }

    public function testSubtractionUnderflow()
    {
        $this->expectException(\UnderflowException::class);
        $uint8a = new UInt8(50);
        $uint8b = new UInt8(100);
        $uint8a->subtract($uint8b);
    }

    public function testMultiplicationWithinBounds()
    {
        $uint8a = new UInt8(10);
        $uint8b = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8(20);
        $uint8c = $uint8a->multiply($uint8b);
        $this->assertSame(200, $uint8c->getValue());
    }

    public function testMultiplicationOverflow()
    {
        $this->expectException(\OverflowException::class);
        $uint8a = new UInt8(16);
        $uint8b = new UInt8(16);
        $uint8a->multiply($uint8b);
    }

    public function testDivisionWithinBounds()
    {
        $uint8a = new UInt8(100);
        $uint8b = new UInt8(4);
        $uint8c = $uint8a->divide($uint8b);
        $this->assertSame(25, $uint8c->getValue());
    }

    public function testDivisionByZero()
    {
        $this->expectException(\DivisionByZeroError::class);
        $uint8a = new UInt8(100);
        $uint8b = new UInt8(0);
        $uint8a->divide($uint8b);
    }

    public function testModulusWithinBounds()
    {
        $uint8a = new UInt8(100);
        $uint8b = new UInt8(30);
        $uint8c = $uint8a->mod($uint8b);
        $this->assertSame(10, $uint8c->getValue());
    }

    public function testEquality()
    {
        $uint8a = new UInt8(50);
        $uint8b = new UInt8(50);
        $this->assertTrue($uint8a->equals($uint8b));
    }

    public function testInequality()
    {
        $uint8a = new UInt8(50);
        $uint8b = new UInt8(60);
        $this->assertFalse($uint8a->equals($uint8b));
    }

    public function testComparison()
    {
        $uint8a = new UInt8(50);
        $uint8b = new UInt8(60);
        $this->assertSame(-1, $uint8a->compare($uint8b));
        $this->assertSame(1, $uint8b->compare($uint8a));
        $uint8c = new UInt8(50);
        $this->assertSame(0, $uint8a->compare($uint8c));
    }
}
