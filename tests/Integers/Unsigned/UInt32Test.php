<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests\Integers\Unsigned;

use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32;
use PHPUnit\Framework\TestCase;

class UInt32Test extends TestCase
{
    public function testValidInitialization()
    {
        $uint32 = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(4294967295);
        $this->assertSame(4294967295, $uint32->getValue());
    }

    public function testInvalidInitialization()
    {
        $this->expectException(\OutOfRangeException::class);
        new UInt32(4294967296);
    }

    public function testAdditionWithinBounds()
    {
        $uint32a = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(4000000000);
        $uint32b = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(294967295);
        $uint32c = $uint32a->add($uint32b);
        $this->assertSame(4294967295, $uint32c->getValue());
    }

    public function testAdditionOverflow()
    {
        $this->expectException(\OverflowException::class);
        $uint32a = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(4000000000);
        $uint32b = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(300000000);
        $uint32a->add($uint32b);
    }

    public function testSubtractionWithinBounds()
    {
        $uint32a = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(4000000000);
        $uint32b = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(1000000000);
        $uint32c = $uint32a->subtract($uint32b);
        $this->assertSame(3000000000, $uint32c->getValue());
    }

    public function testSubtractionUnderflow()
    {
        $this->expectException(\UnderflowException::class);
        $uint32a = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(1000000000);
        $uint32b = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(2000000000);
        $uint32a->subtract($uint32b);
    }

    public function testMultiplicationWithinBounds()
    {
        $uint32a = new UInt32(200000);
        $uint32b = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(20000);
        $uint32c = $uint32a->multiply($uint32b);
        $this->assertSame(4000000000, $uint32c->getValue());
    }

    public function testMultiplicationOverflow()
    {
        $this->expectException(\OverflowException::class);
        $uint32a = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(300000);
        $uint32b = new UInt32(20000);
        $uint32a->multiply($uint32b);
    }

    public function testDivisionWithinBounds()
    {
        $uint32a = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(4000000000);
        $uint32b = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(4);
        $uint32c = $uint32a->divide($uint32b);
        $this->assertSame(1000000000, $uint32c->getValue());
    }

    public function testDivisionByZero()
    {
        $this->expectException(\DivisionByZeroError::class);
        $uint32a = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(4000000000);
        $uint32b = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(0);
        $uint32a->divide($uint32b);
    }

    public function testModulusWithinBounds()
    {
        $uint32a = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(4000000000);
        $uint32b = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(3000000000);
        $uint32c = $uint32a->mod($uint32b);
        $this->assertSame(1000000000, $uint32c->getValue());
    }

    public function testEquality()
    {
        $uint32a = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(3000000000);
        $uint32b = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(3000000000);
        $this->assertTrue($uint32a->equals($uint32b));
    }

    public function testInequality()
    {
        $uint32a = new UInt32(3000000000);
        $uint32b = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(4000000000);
        $this->assertFalse($uint32a->equals($uint32b));
    }

    public function testComparison()
    {
        $uint32a = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(3000000000);
        $uint32b = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(4000000000);
        $this->assertSame(-1, $uint32a->compare($uint32b));
        $this->assertSame(1, $uint32b->compare($uint32a));
        $uint32c = new \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32(3000000000);
        $this->assertSame(0, $uint32a->compare($uint32c));
    }
}
