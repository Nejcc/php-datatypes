<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests\Integers\Signed;

use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;
use PHPUnit\Framework\TestCase;

final class Int8Test extends TestCase
{
    public function testValidInitialization()
    {
        $int8 = new Int8(127);
        $this->assertSame(127, $int8->getValue());
    }

    public function testInvalidInitialization()
    {
        $this->expectException(\OutOfRangeException::class);
        new Int8(128);
    }

    public function testAdditionWithinBounds()
    {
        $int8a = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(50);
        $int8b = new Int8(77);
        $int8c = $int8a->add($int8b);
        $this->assertSame(127, $int8c->getValue());
    }

    public function testAdditionOverflow()
    {
        $this->expectException(\OverflowException::class);
        $int8a = new Int8(100);
        $int8b = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(50);
        $int8a->add($int8b);
    }

    public function testSubtractionWithinBounds()
    {
        $int8a = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(-50);
        $int8b = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(-77);
        $int8c = $int8a->subtract($int8b);
        $this->assertSame(27, $int8c->getValue());
    }

    public function testSubtractionUnderflow()
    {
        $this->expectException(\UnderflowException::class);
        $int8a = new Int8(-100);
        $int8b = new Int8(50);
        $int8a->subtract($int8b);
    }

    public function testMultiplicationWithinBounds()
    {
        $int8a = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(10);
        $int8b = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(12);
        $int8c = $int8a->multiply($int8b);
        $this->assertSame(120, $int8c->getValue());
    }

    public function testMultiplicationOverflow()
    {
        $this->expectException(\OverflowException::class);
        $int8a = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(16);
        $int8b = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(8);
        $int8a->multiply($int8b);
    }

    public function testDivisionWithinBounds()
    {
        $int8a = new Int8(100);
        $int8b = new Int8(4);
        $int8c = $int8a->divide($int8b);
        $this->assertSame(25, $int8c->getValue());
    }

    public function testDivisionByZero()
    {
        $this->expectException(\DivisionByZeroError::class);
        $int8a = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(100);
        $int8b = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(0);
        $int8a->divide($int8b);
    }

    public function testDivisionResultNotInteger()
    {
        $this->expectException(\UnexpectedValueException::class);
        $int8a = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(5);
        $int8b = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(2);
        $int8a->divide($int8b);
    }

    public function testModulusWithinBounds()
    {
        $int8a = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(100);
        $int8b = new Int8(30);
        $int8c = $int8a->mod($int8b);
        $this->assertSame(10, $int8c->getValue());
    }

    public function testEquality()
    {
        $int8a = new Int8(50);
        $int8b = new Int8(50);
        $this->assertTrue($int8a->equals($int8b));
    }

    public function testInequality()
    {
        $int8a = new \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8(50);
        $int8b = new Int8(60);
        $this->assertFalse($int8a->equals($int8b));
    }

    public function testComparison()
    {
        $int8a = new Int8(50);
        $int8b = new Int8(60);
        $this->assertSame(-1, $int8a->compare($int8b));
        $this->assertSame(1, $int8b->compare($int8a));
        $int8c = new Int8(50);
        $this->assertSame(0, $int8a->compare($int8c));
    }
}
