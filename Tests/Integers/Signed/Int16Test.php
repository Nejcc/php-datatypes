<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests\Integers\Signed;


use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int16;
use PHPUnit\Framework\TestCase;

class Int16Test extends TestCase
{
    public function testValidInitialization()
    {
        $int16 = new Int16(32767);
        $this->assertSame(32767, $int16->getValue());
    }

    public function testInvalidInitialization()
    {
        $this->expectException(\OutOfRangeException::class);
        new Int16(32768);
    }

    public function testAdditionWithinBounds()
    {
        $int16a = new Int16(20000);
        $int16b = new Int16(12767);
        $int16c = $int16a->add($int16b);
        $this->assertSame(32767, $int16c->getValue());
    }

    public function testAdditionOverflow()
    {
        $this->expectException(\OverflowException::class);
        $int16a = new Int16(30000);
        $int16b = new Int16(5000);
        $int16a->add($int16b);
    }

    public function testSubtractionWithinBounds()
    {
        $int16a = new Int16(-20000);
        $int16b = new Int16(-12767);
        $int16c = $int16a->subtract($int16b);
        $this->assertSame(-7233, $int16c->getValue());
    }

    public function testSubtractionUnderflow()
    {
        $this->expectException(\UnderflowException::class);
        $int16a = new Int16(-30000);
        $int16b = new Int16(5000);
        $int16a->subtract($int16b);
    }

    public function testMultiplicationWithinBounds()
    {
        $int16a = new Int16(150);
        $int16b = new Int16(200);
        $int16c = $int16a->multiply($int16b);
        $this->assertSame(30000, $int16c->getValue());
    }

    public function testMultiplicationOverflow()
    {
        $this->expectException(\OverflowException::class);
        $int16a = new Int16(500);
        $int16b = new Int16(100);
        $int16a->multiply($int16b);
    }

    public function testDivisionWithinBounds()
    {
        $int16a = new Int16(32766);
        $int16b = new Int16(2);
        $int16c = $int16a->divide($int16b);
        $this->assertSame(16383, $int16c->getValue());
    }

    public function testDivisionByZero()
    {
        $this->expectException(\DivisionByZeroError::class);
        $int16a = new Int16(10000);
        $int16b = new Int16(0);
        $int16a->divide($int16b);
    }

    public function testDivisionResultNotInteger()
    {
        $this->expectException(\UnexpectedValueException::class);
        $int16a = new Int16(5);
        $int16b = new Int16(2);
        $int16a->divide($int16b);
    }

    public function testModulusWithinBounds()
    {
        $int16a = new Int16(32767);
        $int16b = new Int16(10000);
        $int16c = $int16a->mod($int16b);
        $this->assertSame(2767, $int16c->getValue());
    }

    public function testEquality()
    {
        $int16a = new Int16(12345);
        $int16b = new Int16(12345);
        $this->assertTrue($int16a->equals($int16b));
    }

    public function testInequality()
    {
        $int16a = new Int16(12345);
        $int16b = new Int16(30000);
        $this->assertFalse($int16a->equals($int16b));
    }

    public function testComparison()
    {
        $int16a = new Int16(12345);
        $int16b = new Int16(30000); // Valid value within range
        $this->assertSame(-1, $int16a->compare($int16b));
        $this->assertSame(1, $int16b->compare($int16a));
        $int16c = new Int16(12345);
        $this->assertSame(0, $int16a->compare($int16c));
    }
}
