<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests\Integers\Signed;

use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int32;
use PHPUnit\Framework\TestCase;

final class Int32Test extends TestCase
{
    public function testValidInitialization()
    {
        $int32 = new Int32(2147483647);
        $this->assertSame(2147483647, $int32->getValue());
    }

    public function testInvalidInitialization()
    {
        $this->expectException(\OutOfRangeException::class);
        new Int32(2147483648);
    }

    public function testAdditionWithinBounds()
    {
        $int32a = new Int32(1000000000);
        $int32b = new Int32(1147483647);
        $int32c = $int32a->add($int32b);
        $this->assertSame(2147483647, $int32c->getValue());
    }

    public function testAdditionOverflow()
    {
        $this->expectException(\OverflowException::class);
        $int32a = new Int32(2000000000);
        $int32b = new Int32(2000000000);
        $int32a->add($int32b);
    }

    public function testSubtractionWithinBounds()
    {
        $int32a = new Int32(-1000000000);
        $int32b = new Int32(-1147483647);
        $int32c = $int32a->subtract($int32b);
        $this->assertSame(147483647, $int32c->getValue());
    }

    public function testSubtractionUnderflow()
    {
        $this->expectException(\UnderflowException::class);
        $int32a = new Int32(-2000000000);
        $int32b = new Int32(2000000000);
        $int32a->subtract($int32b);
    }

    public function testMultiplicationWithinBounds()
    {
        $int32a = new Int32(46340); // sqrt of MAX_VALUE approx
        $int32b = new Int32(46340);
        $int32c = $int32a->multiply($int32b);
        $this->assertSame(2147395600, $int32c->getValue());
    }

    public function testMultiplicationOverflow()
    {
        $this->expectException(\OverflowException::class);
        $int32a = new Int32(50000);
        $int32b = new Int32(50000);
        $int32a->multiply($int32b);
    }

    public function testDivisionWithinBounds()
    {
        $int32a = new Int32(2147483646);
        $int32b = new Int32(2);
        $int32c = $int32a->divide($int32b);
        $this->assertSame(1073741823, $int32c->getValue());
    }

    public function testDivisionByZero()
    {
        $this->expectException(\DivisionByZeroError::class);
        $int32a = new Int32(1000000000);
        $int32b = new Int32(0);
        $int32a->divide($int32b);
    }

    public function testDivisionResultNotInteger()
    {
        $this->expectException(\UnexpectedValueException::class);
        $int32a = new Int32(5);
        $int32b = new Int32(2);
        $int32a->divide($int32b);
    }

    public function testModulusWithinBounds()
    {
        $int32a = new Int32(2147483647);
        $int32b = new Int32(1000000000);
        $int32c = $int32a->mod($int32b);
        $this->assertSame(147483647, $int32c->getValue());
    }

    public function testEquality()
    {
        $int32a = new Int32(1234567890);
        $int32b = new Int32(1234567890);
        $this->assertTrue($int32a->equals($int32b));
    }

    public function testInequality()
    {
        $int32a = new Int32(1234567890);
        $int32b = new Int32(987654321);
        $this->assertFalse($int32a->equals($int32b));
    }

    public function testComparison()
    {
        $int32a = new Int32(1234567890);
        $int32b = new Int32(987654321);
        $this->assertSame(1, $int32a->compare($int32b));
        $this->assertSame(-1, $int32b->compare($int32a));
        $int32c = new Int32(1234567890);
        $this->assertSame(0, $int32a->compare($int32c));
    }
}
