<?php

declare(strict_types=1);

namespace Tests\Scalar\Integers\Signed;

use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int128;
use PHPUnit\Framework\TestCase;

final class Int128Test extends TestCase
{
    public function testValidRange(): void
    {
        $min = new Int128('-170141183460469231731687303715884105728');
        $max = new Int128('170141183460469231731687303715884105727');
        $zero = new Int128('0');
        $middle = new Int128('123456789012345678901234567890123456');
        $this->assertSame('-170141183460469231731687303715884105728', $min->getValue());
        $this->assertSame('170141183460469231731687303715884105727', $max->getValue());
        $this->assertSame('0', $zero->getValue());
        $this->assertSame('123456789012345678901234567890123456', $middle->getValue());
    }

    public function testInvalidRange(): void
    {
        $this->expectException(\OutOfRangeException::class);
        new Int128('170141183460469231731687303715884105728'); // MAX_VALUE + 1
    }

    public function testNegativeInvalidRange(): void
    {
        $this->expectException(\OutOfRangeException::class);
        new Int128('-170141183460469231731687303715884105729'); // MIN_VALUE - 1
    }

    public function testAddition(): void
    {
        $a = new Int128('170141183460469231731687303715884105720');
        $b = new Int128('7');
        $c = $a->add($b);
        $this->assertSame('170141183460469231731687303715884105727', $c->getValue());
    }

    public function testAdditionOverflow(): void
    {
        $max = new Int128('170141183460469231731687303715884105727');
        $this->expectException(\OverflowException::class);
        $max->add(new Int128('1'));
    }

    public function testAdditionUnderflow(): void
    {
        $min = new Int128('-170141183460469231731687303715884105728');
        $this->expectException(\UnderflowException::class);
        $min->add(new Int128('-1'));
    }

    public function testSubtraction(): void
    {
        $a = new Int128('170141183460469231731687303715884105720');
        $b = new Int128('7');
        $c = $a->subtract($b);
        $this->assertSame('170141183460469231731687303715884105713', $c->getValue());
    }

    public function testSubtractionOverflow(): void
    {
        $max = new Int128('170141183460469231731687303715884105727');
        $this->expectException(\OverflowException::class);
        $max->subtract(new Int128('-1'));
    }

    public function testSubtractionUnderflow(): void
    {
        $min = new Int128('-170141183460469231731687303715884105728');
        $this->expectException(\UnderflowException::class);
        $min->subtract(new Int128('1'));
    }

    public function testMultiplication(): void
    {
        $a = new Int128('100');
        $b = new Int128('50');
        $c = $a->multiply($b);
        $this->assertSame('5000', $c->getValue());
    }

    public function testMultiplicationOverflow(): void
    {
        $max = new Int128('170141183460469231731687303715884105727');
        $this->expectException(\OverflowException::class);
        $max->multiply(new Int128('2'));
    }

    public function testMultiplicationUnderflow(): void
    {
        $min = new Int128('-170141183460469231731687303715884105728');
        $this->expectException(\UnderflowException::class);
        $min->multiply(new Int128('2'));
    }

    public function testDivision(): void
    {
        $a = new Int128('10000');
        $b = new Int128('2');
        $c = $a->divide($b);
        $this->assertSame('5000', $c->getValue());
    }

    public function testDivisionByZero(): void
    {
        $a = new Int128('100');
        $b = new Int128('0');
        $this->expectException(\DivisionByZeroError::class);
        $a->divide($b);
    }

    public function testDivisionNonIntegerResult(): void
    {
        $a = new Int128('5');
        $b = new Int128('2');
        $this->expectException(\UnexpectedValueException::class);
        $a->divide($b);
    }

    public function testEquals(): void
    {
        $a = new Int128('100');
        $b = new Int128('100');
        $c = new Int128('50');
        $this->assertTrue($a->equals($b));
        $this->assertFalse($a->equals($c));
    }

    public function testIsGreaterThan(): void
    {
        $a = new Int128('200');
        $b = new Int128('100');
        $this->assertTrue($a->isGreaterThan($b));
        $this->assertFalse($b->isGreaterThan($a));
    }

    public function testIsLessThan(): void
    {
        $a = new Int128('100');
        $b = new Int128('200');
        $this->assertTrue($a->isLessThan($b));
        $this->assertFalse($b->isLessThan($a));
    }

    public function testStringConversion(): void
    {
        $a = new Int128('123456789012345678901234567890123456');
        $this->assertSame('123456789012345678901234567890123456', (string)$a);
    }

    public function testZeroOperations(): void
    {
        $zero = new Int128('0');
        $a = new Int128('100');
        $this->assertSame('100', $a->add($zero)->getValue());
        $this->assertSame('100', $a->subtract($zero)->getValue());
        $this->assertSame('0', $a->multiply($zero)->getValue());
        $this->assertSame('0', $zero->add($zero)->getValue());
    }
}
